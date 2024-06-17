<?php

namespace App\Services;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;

class CommentService
{
    public function getComments($per_page)
    {
        return Comment::paginate($per_page);
    }

    public function countComments(): int
    {
        return Comment::count();
    }

    public function getCommentById($id)
    {
        return Comment::where('id', $id)->first();
    }

    public function getCommentsWithLimit($limit)
    {
        return Comment::orderBy('created_at', 'desc')->limit($limit)->paginate($limit);
    }

    public function getCommentsByUserId($user_id, $per_page)
    {
        return Comment::where('user_id', $user_id)->paginate($per_page);
    }

    public function save(CommentRequest $request): void
    {
        $comment = new Comment();
        $comment->user_id = 1; // Auth::user()->id
        $comment->post_id = $request->post_id;
        $comment->comment = $request->comment;
        $comment->save();
    }

    public function update(CommentRequest $request)
    {
        $comment = $this->getCommentById($request->id);
        $comment->comment = $request->comment;
        $comment->save();

        return $comment;
    }
}
