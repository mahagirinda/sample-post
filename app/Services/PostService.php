<?php

namespace App\Services;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostService
{
    public function getAllPost($per_page)
    {
        return Post::paginate($per_page);
    }

    public function countPost(): int
    {
        return Post::count();
    }

    public function getPostById($id)
    {
        return Post::where('id', $id)->firstOrFail();
    }

    public function getActivePostByWithLimit($limit)
    {
        return Post::where('draft', 0)->whereHas('category', function ($query) {
            $query->where('status', 1);
        })->orderBy('created_at', 'desc')->limit($limit)->paginate($limit);
    }

    public function countViewPost($id): void
    {
        $post = $this->getPostById($id);
        $post->timestamps = false;
        $post->visit_counts = $post->visit_counts + 1;
        $post->save();
    }

    public function getPostForHomePage()
    {
        return Post::where('draft', 0)->whereHas('category', function ($query) {
            $query->where('status', 1);
        })->withCount('comments')->orderBy('created_at', 'desc')->paginate(6);
    }

    public function getPostByUserId($user_id, $per_page)
    {
        return Post::where('user_id', $user_id)->paginate($per_page);
    }

    public function save(PostRequest $request): void
    {
        $post = new Post();
        $post->title = $request->title;
        $post->draft = $request->draft === "on";
        $post->user_id = Auth::user()->id;
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . request()->image->getClientOriginalExtension();
            $request->file('image')->storeAs('image/post', $imageName, 'public');
            $post->image = $imageName;
        }
        $post->category_id = $request->category_id;
        $post->contents = $request->post_content;
        $post->save();
    }

    public function update($request)
    {
        $post = $this->getPostById($request->id);
        if ($this->checkUpdateDraftOnly($post, $request)) {
            $post->timestamps = false;
        }

        $post->title = $request->title;
        $post->draft = $request->draft === "on";
        $post->user_id = Auth::user()->id;
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

        return $post;
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
