<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Category;
use App\Models\Post;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PostController extends Controller
{
    function dashboard(): View
    {
        return view('dashboard');
    }

    function home(): View
    {
        $posts = Post::where('draft', 0)
                ->withCount('comments')
                ->orderBy('created_at', 'desc')
                ->paginate(6);
        return view('home', compact('posts'));
    }

    function create(): View
    {
        $categories = Category::orderBy('name', 'asc')->get();
        return view('post.create', compact('categories'));
    }

    function user(): View
    {
        // $id = Auth::user()->id;
        $id = '1';
        $posts = Post::where('user_id', $id)->paginate(10);
        return view('post.user', compact('posts'));
    }

    function view(String $id): View | RedirectResponse
    {
        $post = Post::where('id', $id)->firstOrFail();
        if (!$post->draft) {
            $post->timestamps = false;
            $post->visit_counts = $post->visit_counts + 1;
            $post->save();
            return view('post.view', compact('post'));
        } else {
            return redirect()->back()->with("error", "Post on draft cannot be viewed!.");
        }
    }

    public function store(PostRequest $request): RedirectResponse
    {
        try {
            $post = new Post();
            $post->title = $request->title;
            $post->draft = $request->draft === "on";
            // $post->user_id = Auth::user()->id;
            $post->user_id = 1;
            if ($request->hasFile('image')) {
                $imageName = time() . '.' . request()->image->getClientOriginalExtension();
                $request->file('image')->storeAs('image/post', $imageName, 'public');
                $post->image = $imageName;
            }
            $post->category_id = $request->category_id;
            $post->contents = $request->post_content;
            $post->save();
        } catch (Exception $e) {
            Log::channel('log-error')->error($e->getMessage());
            return redirect()
                ->route('post.create')
                ->with('error', "Error : " . $e->getMessage());
        }

        return redirect()->route('post.create')->with('success', 'Post saved successfully!');
    }

    function edit_list(): View
    {
        $posts = Post::paginate(10);
        return view('post.edit-list', compact('posts'));
    }

    function edit($id): View
    {
        $post = Post::where('id', $id)->first();
        $categories = Category::orderBy('name', 'asc')->get();
        return view('post.edit', compact('post', 'categories'));
    }

    public function update(PostRequest $request): RedirectResponse
    {
        $post = Post::where('id', $request->id)->first();
        try {
            if ($this->checkUpdateDraftOnly($post, $request)) {
                $post->timestamps = false;
            }

            $post->title = $request->title;
            $post->draft = $request->draft === "on";
            // $post->user_id = Auth::user()->id;
            $post->user_id = 1;
            if ($request->hasFile('image')) {
                if (Storage::disk('public')->exists('image/post/' . $post->image)) {
                    Storage::disk('public')->delete('image/post/' . $post->image);
                }
                $imageName = time() . '.' . request()->image->getClientOriginalExtension();
                $request->file('image')->storeAs('image/post', $imageName, 'public');
                $post->image = $imageName;
            }
            $post->category_id = $request->category_id;
            $post->contents = $request->post_content;
            $post->save();
        } catch (Exception $e) {
            Log::channel('log-error')->error($e->getMessage());
            return redirect()
                ->route('post.edit', ['id' => $post->id])
                ->with('error', "Error : " . $e->getMessage());
        }

        $parameter = ['id' => $post->id];
        return redirect()->route('post.edit', $parameter)->with('success', 'Post updated successfully!');
    }

    function inquiry(): View
    {
        $posts = Post::paginate(10);
        return view('post.inquiry', compact('posts'));
    }

    function checkUpdateDraftOnly(Post $post, PostRequest $updatedRequest): bool
    {
        if ($post->draft == "on" && $updatedRequest->draft) {
            return true;
        }
        if ($post->draft == "off" && !$updatedRequest->draft) {
            return true;
        }
        return false;
    }
}
