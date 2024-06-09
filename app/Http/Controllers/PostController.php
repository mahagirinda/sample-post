<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
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
        $posts = Post::all()->sortByDesc('created_at');
        return view('home')->with('posts', $posts);
    }

    function create(): View
    {
        return view('post.create');
    }

    public function store(PostRequest $request): RedirectResponse
    {
        try {
            $post = new Post();
            $post->title = $request->title;
            if ($request->hasFile('image')) {
                $imageName = time() . '.' . request()->image->getClientOriginalExtension();
                $request->file('image')->storeAs('image/post', $imageName, 'public');
                $post->image = $imageName;
            }
            $post->category = $request->category;
            $post->content = $request->post_content;
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
        $posts = Post::all();
        return view('post.edit-list', compact('posts'));
    }

    function edit($id): View
    {
        $post = Post::where('id', $id)->first();
        return view('post.edit')->with('post', $post);
    }

    public function update(PostRequest $request): RedirectResponse
    {
        $post = Post::where('id', $request->id)->first();
        try {
            $post->title = $request->title;
            $post->category = $request->category;
            $post->content = $request->post_content;
            if ($request->hasFile('image')) {
                if (Storage::disk('public')->exists('image/post/' . $post->image)) {
                    Storage::disk('public')->delete('image/post/' . $post->image);
                }
                $imageName = time() . '.' . request()->image->getClientOriginalExtension();
                $request->file('image')->storeAs('image/post', $imageName, 'public');
                $post->image = $imageName;
            }
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
        $posts = Post::all();
        return view('post.inquiry', compact('posts'));
    }
}
