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

    /**
     * Store a newly created comment.
     *
     * @param CommentRequest $request The incoming request containing the form data.
     * @return RedirectResponse A redirect response indicating success or failure.
     */
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

    /**
     * Display the comments of the authenticated user.
     *
     * @return View The view displaying the list of comments for the authenticated user.
     */
    function user(): View
    {
        $id = Auth::user()->id;
        $comments = $this->commentService->getCommentsByUserId($id, 10);
        return view('comments.user', compact('comments'));
    }

    /**
     * Display a listing of comments for editing.
     *
     * @return View The view displaying the list of comments for editing.
     */
    function edit_list(): View
    {
        $comments = $this->commentService->getComments(10);
        return view('comments.edit-list', compact('comments'));
    }

    /**
     * Show the form for editing the specified comment.
     *
     * @param string $id The ID of the comment to edit.
     * @return View The view displaying the form to edit the comment details.
     */
    function edit($id): View
    {
        $comment = $this->commentService->getCommentById($id);
        return view('comments.edit', compact('comment'));
    }

    /**
     * Show the form for editing the specified comment by the authenticated user.
     *
     * This method retrieves the comment by its ID using the comment service and checks
     * if the authenticated user is the owner of the comment. If the user is not the owner,
     * it redirects back with an error message. Otherwise, it returns a view displaying
     * the form to edit the comment details.
     *
     * @param string $id The ID of the comment to edit.
     * @return View|RedirectResponse The view displaying the form to edit the comment details or a redirect response if the user is not the owner.
     */
    function user_edit($id): View | RedirectResponse
    {
        $comment = $this->commentService->getCommentById($id);
        if (Auth::user()->id != $comment->user_id) {
            return redirect()->back()->with('error', 'You cannot edit other users comment!');
        }
        return view('comments.user-edit', compact('comment'));
    }

    /**
     * Update the specified comment.
     *
     * @param CommentRequest $request The incoming request containing the form data.
     * @return RedirectResponse A redirect response indicating success or failure.
     */
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

    /**
     * Update the specified comment by the authenticated user.
     *
     * @param CommentRequest $request The incoming request containing the form data.
     * @return RedirectResponse A redirect response indicating success or failure.
     */
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

    /**
     * Display a listing of comments for inquiry.
     *
     * @return View The view displaying the list of comments for inquiry.
     */
    function inquiry(): View
    {
        $comments = $this->commentService->getComments(20);
        return view('comments.inquiry', compact('comments'));
    }

    /**
     * Generate the start log message for a comment operation.
     *
     * @param string $method The method of the comment operation (e.g., create, update).
     * @return void
     */
    function generateStartLogMessage(string $method): void
    {
        $message = $this->controllerName . Auth::user()->name . " is trying to " . $method . " a comment ...";
        $this->commonService->writeLog($message);
    }

    /**
     * Generate the end log message for a comment operation.
     *
     * @param string $method The method of the comment operation (e.g., create, update).
     * @param CommentRequest $request The incoming request containing the form data.
     * @return void
     */
    function generateEndLogMessage(string $method, CommentRequest $request): void
    {
        $message = $this->controllerName . Auth::user()->name
            . " success " .$method. " a comment with comment : " . $request->comment;
        $this->commonService->writeLog($message);
    }
}
