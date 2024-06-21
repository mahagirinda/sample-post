<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Services\CategoryService;
use App\Services\CommonService;
use App\Services\PostService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PostController extends Controller
{
    private PostService $postService;
    private CategoryService $categoryService;
    private CommonService $commonService;
    private string $controllerName = '[PostController] ';

    public function __construct(CategoryService $categoryService,
                                PostService $postService, CommonService $commonService)
    {
        $this->postService = $postService;
        $this->categoryService = $categoryService;
        $this->commonService = $commonService;
    }

    /**
     * Show the form for creating a new post.
     *
     * @return View The view displaying the form to create a new post.
     */
    function create(): View
    {
        $categories = $this->categoryService->getActiveCategories();
        return view('post.create', compact('categories'));
    }

    /**
     * Display a listing of the authenticated user's posts.
     *
     * @return View The view displaying the authenticated user's posts.
     */
    function user(): View
    {
        $id = Auth::user()->id;
        $posts = $this->postService->getPostByUserId($id, 10);
        return view('post.user', compact('posts'));
    }

    /**
     * Display the specified post.
     *
     * This method retrieves a post by its ID from the post service. If the post is not a draft,
     * it increments the view count for the post and returns a view displaying the post.
     * If the post is a draft, it redirects back with an error message.
     *
     * @param string $id The ID of the post to be displayed.
     * @return View|RedirectResponse The view displaying the post or a redirect response with an error message.
     */
    function view(string $id): View|RedirectResponse
    {
        $post = $this->postService->getPostById($id);
        if (!$post->draft) {
            $this->postService->countViewPost($id);
            return view('post.view', compact('post'));
        } else {
            return redirect()->back()->with("error", "Post on draft cannot be viewed!.");
        }
    }

    /**
     * Store a newly created post.
     *
     * @param PostRequest $request The incoming request containing the form data.
     * @return RedirectResponse A redirect response indicating success or failure.
     */
    public function store(PostRequest $request): RedirectResponse
    {
        $this->generateStartLogMessage("create");

        try {
            $this->postService->save($request);
        } catch (Exception $e) {
            $errorMessage = $this->commonService->writeErrorLog($e);
            return redirect()->route('post.create')->with('error', $errorMessage);
        }

        $this->generateEndLogMessage("create", $request);
        return redirect()->route('post.create')->with('success', 'Post saved successfully!');
    }

    /**
     * Display a listing of posts for editing.
     *
     * @return View The view displaying the list of posts for editing.
     */
    function edit_list(): View
    {
        $posts = $this->postService->getAllPost(10);
        return view('post.edit-list', compact('posts'));
    }

    /**
     * Show the form for editing the specified post.
     *
     * @param string $id The ID of the post to be edited.
     * @return View The view displaying the form to edit the specified post.
     */
    function edit($id): View
    {
        $post = $this->postService->getPostById($id);
        $categories = $this->categoryService->getActiveCategories();
        return view('post.edit', compact('post', 'categories'));
    }

    /**
     * Show the form for editing the authenticated user's post.
     *
     * @param string $id The ID of the post to be edited.
     * @return View|RedirectResponse The view displaying the form to edit the post or a redirect response with an error message.
     */
    function user_edit($id): View|RedirectResponse
    {
        $post = $this->postService->getPostById($id);
        $categories = $this->categoryService->getActiveCategories();
        if (Auth::user()->id != $post->user_id) {
            return redirect()->back()->with('error', 'You cannot edit other users post!');
        }
        return view('post.user-edit', compact('post', 'categories'));
    }

    /**
     * Update the specified post.
     *
     * @param PostRequest $request The incoming request containing the form data.
     * @return RedirectResponse A redirect response indicating success or failure.
     */
    public function update(PostRequest $request): RedirectResponse
    {
        $this->generateStartLogMessage("update");

        try {
            $post = $this->postService->update($request);
        } catch (Exception $e) {
            $errorMessage = $this->commonService->writeErrorLog($e);
            return redirect()->route('post.edit', ['id' => $request->id])->with($errorMessage);
        }

        $parameter = ['id' => $post->id];
        $this->generateEndLogMessage("update", $request);
        return redirect()->route('post.edit', $parameter)->with('success', 'Post updated successfully!');
    }

    /**
     * Update the authenticated user's specified post.
     *
     * @param PostRequest $request The incoming request containing the form data.
     * @return RedirectResponse A redirect response indicating success or failure.
     */
    public function user_update(PostRequest $request): RedirectResponse
    {
        $this->generateStartLogMessage("update");

        try {
            $post = $this->postService->update($request);
            if (Auth::user()->id != $post->user_id) {
                return redirect()->back()->with('error', 'You cannot edit other users post!');
            }
        } catch (Exception $e) {
            $errorMessage = $this->commonService->writeErrorLog($e);
            return redirect()->route('post.edit', ['id' => $request->id])->with($errorMessage);
        }

        $parameter = ['id' => $post->id];
        $this->generateEndLogMessage("update", $request);
        return redirect()->route('post.user.edit', $parameter)->with('success', 'Post updated successfully!');
    }

    /**
     * Display a listing of posts for inquiry.
     *
     * @return View The view displaying the list of posts for inquiry.
     */
    function inquiry(): View
    {
        $posts = $this->postService->getAllPost(20);
        return view('post.inquiry', compact('posts'));
    }

    /**
     * Generate a start log message for a post operation.
     *
     * @param string $method The name of the method being executed (e.g., create, update, delete).
     * @return void
     */
    function generateStartLogMessage(string $method): void
    {
        $message = $this->controllerName . Auth::user()->name . " is trying to " . $method . " a post ...";
        $this->commonService->writeLog($message);
    }

    /**
     * Generate an end log message for a post operation.
     *
     * @param string $method The name of the method that was executed (e.g., create, update, delete).
     * @param PostRequest $request The request object containing details of the post operation.
     * @return void
     */
    function generateEndLogMessage(string $method, PostRequest $request): void
    {
        $message = $this->controllerName . Auth::user()->name
            . " success " .$method. " a post with title : " . $request->title;
        $this->commonService->writeLog($message);
    }

}
