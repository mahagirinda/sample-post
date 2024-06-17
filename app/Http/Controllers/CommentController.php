<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Services\CommentService;
use App\Services\CommonService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class CommentController extends Controller
{
    private CommentService $commentService;
    private CommonService $commonService;

    public function __construct(CommentService $commentService, CommonService $commonService)
    {
        $this->commentService = $commentService;
        $this->commonService = $commonService;
    }

    public function store(CommentRequest $request): RedirectResponse
    {
        try {
            $this->commentService->save($request);
        } catch (Exception $e) {
            $errorMessage = $this->commonService->writeErrorLog($e);
            return redirect()->back()->with('error', $errorMessage);
        }

        return redirect()->back()->with('success', 'Comment saved successfully!');
    }

    function user(): View
    {
        $id = '1'; // Auth::user()->id;
        $comments = $this->commentService->getCommentsByUserId($id, 10);
        return view('comments.user', compact('comments'));
    }

    function edit_list(): View
    {
        $comments = $this->commentService->getComments(10);
        return view('comments.edit-list', compact('comments'));
    }

    function edit($id): View
    {
        $comment = $this->commentService->getCommentById($id);
        return view('comments.edit', compact('comment'));
    }

    function user_edit($id): View
    {
        $comment = $this->commentService->getCommentById($id);
        return view('comments.user-edit', compact('comment'));
    }

    public function update(CommentRequest $request): RedirectResponse
    {
        try {
            $comment = $this->commentService->update($request);
        } catch (Exception $e) {
            $errorMessage = $this->commonService->writeErrorLog($e);
            return redirect()->route('comment.edit', ['id' => $request->id])->with('error', $errorMessage);
        }

        $parameter = ['id' => $comment->id];
        return redirect()->route('comment.edit', $parameter)->with('success', 'Comment updated successfully!');
    }

    public function user_update(CommentRequest $request): RedirectResponse
    {
        try {
            $comment = $this->commentService->update($request);
        } catch (Exception $e) {
            $errorMessage = $this->commonService->writeErrorLog($e);
            return redirect()->route('comment.edit', ['id' => $request->id])->with('error', $errorMessage);
        }

        $parameter = ['id' => $comment->id];
        return redirect()->route('comment.user.edit', $parameter)->with('success', 'Comment updated successfully!');
    }

    function inquiry(): View
    {
        $comments = $this->commentService->getComments(20);
        return view('comments.inquiry', compact('comments'));
    }
}
