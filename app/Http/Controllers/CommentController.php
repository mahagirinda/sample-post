<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Services\CommentService;
use App\Services\CommonService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CommentController extends Controller
{
    private CommentService $commentService;
    private CommonService $commonService;
    private string $controllerName = '[CommentController] ';

    public function __construct(CommentService $commentService, CommonService $commonService)
    {
        $this->commentService = $commentService;
        $this->commonService = $commonService;
    }

    public function store(CommentRequest $request): RedirectResponse
    {
        $this->generateStartLogMessage("create");

        try {
            $this->commentService->save($request);
        } catch (Exception $e) {
            $errorMessage = $this->commonService->writeErrorLog($e);
            return redirect()->back()->with('error', $errorMessage);
        }

        $this->generateEndLogMessage("create", $request);
        return redirect()->back()->with('success', 'Comment saved successfully!');
    }

    function user(): View
    {
        $id = Auth::user()->id;
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

    function user_edit($id): View | RedirectResponse
    {
        $comment = $this->commentService->getCommentById($id);
        if (Auth::user()->id != $comment->user_id) {
            return redirect()->back()->with('error', 'You cannot edit other users comment!');
        }
        return view('comments.user-edit', compact('comment'));
    }

    public function update(CommentRequest $request): RedirectResponse
    {
        $this->generateStartLogMessage("update");

        try {
            $comment = $this->commentService->update($request);
        } catch (Exception $e) {
            $errorMessage = $this->commonService->writeErrorLog($e);
            return redirect()->route('comment.edit', ['id' => $request->id])->with('error', $errorMessage);
        }

        $parameter = ['id' => $comment->id];
        $this->generateEndLogMessage("update", $request);
        return redirect()->route('comment.edit', $parameter)->with('success', 'Comment updated successfully!');
    }

    public function user_update(CommentRequest $request): RedirectResponse
    {
        $this->generateStartLogMessage("update");

        try {
            $comment = $this->commentService->update($request);
            if (Auth::user()->id != $comment->user_id) {
                return redirect()->back()->with('error', 'You cannot edit other users comment!');
            }
        } catch (Exception $e) {
            $errorMessage = $this->commonService->writeErrorLog($e);
            return redirect()->route('comment.edit', ['id' => $request->id])->with('error', $errorMessage);
        }

        $parameter = ['id' => $comment->id];
        $this->generateEndLogMessage("update", $request);
        return redirect()->route('comment.user.edit', $parameter)->with('success', 'Comment updated successfully!');
    }

    function inquiry(): View
    {
        $comments = $this->commentService->getComments(20);
        return view('comments.inquiry', compact('comments'));
    }

    function generateStartLogMessage(string $method): void
    {
        $message = $this->controllerName . Auth::user()->name . " is trying to " . $method . " a comment ...";
        $this->commonService->writeLog($message);
    }

    function generateEndLogMessage(string $method, CommentRequest $request): void
    {
        $message = $this->controllerName . Auth::user()->name
            . " success " .$method. " a comment with comment : " . $request->comment;
        $this->commonService->writeLog($message);
    }
}
