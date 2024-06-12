<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Http\Requests\PostRequest;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CommentController extends Controller
{
    public function store(CommentRequest $request): RedirectResponse
    {
        $comment = new Comment();
        try {
            //$comment->user_id = Auth::user()->id;
            $comment->user_id = 1;
            $comment->post_id = $request->post_id;
            $comment->comment = $request->comment;
            $comment->save();
        } catch (Exception $e) {
            Log::channel('log-error')->error($e->getMessage());
            return redirect()
                ->back()->with('error', "Error : " . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Comment saved successfully!');
    }

    function user(): View
    {
        // $id = Auth::user()->id;
        $id = '1';
        $comments = Comment::where('user_id', $id)->paginate(10);
        return view('comments.user', compact('comments'));
    }

    function edit($id): View
    {
        $comment = Comment::where('id', $id)->first();
        return view('comments.edit', compact('comment'));
    }

    public function update(CommentRequest $request): RedirectResponse
    {
        $comment = Comment::where('id', $request->id)->first();
        try {
            $comment->comment = $request->comment;
            $comment->save();
        } catch (Exception $e) {
            Log::channel('log-error')->error($e->getMessage());
            return redirect()
                ->route('comment.edit', ['id' => $comment->id])
                ->with('error', "Error : " . $e->getMessage());
        }

        $parameter = ['id' => $comment->id];
        return redirect()->route('comment.edit', $parameter)->with('success', 'Comment updated successfully!');
    }
}
