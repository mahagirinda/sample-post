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

    function create(): View
    {
        $categories = $this->categoryService->getActiveCategories();
        return view('post.create', compact('categories'));
    }

    function user(): View
    {
        $id = Auth::user()->id;
        $posts = $this->postService->getPostByUserId($id, 10);
        return view('post.user', compact('posts'));
    }

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

    function edit_list(): View
    {
        $posts = $this->postService->getAllPost(10);
        return view('post.edit-list', compact('posts'));
    }

    function edit($id): View
    {
        $post = $this->postService->getPostById($id);
        $categories = $this->categoryService->getActiveCategories();
        return view('post.edit', compact('post', 'categories'));
    }

    function user_edit($id): View|RedirectResponse
    {
        $post = $this->postService->getPostById($id);
        $categories = $this->categoryService->getActiveCategories();
        if (Auth::user()->id != $post->user_id) {
            return redirect()->back()->with('error', 'You cannot edit other users post!');
        }
        return view('post.user-edit', compact('post', 'categories'));
    }

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

    function inquiry(): View
    {
        $posts = $this->postService->getAllPost(20);
        return view('post.inquiry', compact('posts'));
    }

    function generateStartLogMessage(string $method): void
    {
        $message = $this->controllerName . Auth::user()->name . " is trying to " . $method . " a post ...";
        $this->commonService->writeLog($message);
    }

    function generateEndLogMessage(string $method, PostRequest $request): void
    {
        $message = $this->controllerName . Auth::user()->name
            . " success " .$method. " a post with title : " . $request->title;
        $this->commonService->writeLog($message);
    }

}
