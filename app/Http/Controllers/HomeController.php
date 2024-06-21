<?php

namespace App\Http\Controllers;

use App\Services\CommentService;
use App\Services\PostService;
use App\Services\UserService;
use Illuminate\View\View;

class HomeController extends Controller
{
    private PostService $postService;
    private UserService $userService;
    private CommentService $commentService;

    public function __construct(PostService $postService, UserService $userService,
                                CommentService $commentService)
    {
        $this->postService = $postService;
        $this->userService = $userService;
        $this->commentService = $commentService;
    }

    function dashboard(): View
    {
        $dashboard = (object)array();
        $dashboard->post = $this->postService->countPost();
        $dashboard->user = $this->userService->countUsers();
        $dashboard->comment = $this->commentService->countComments();

        $posts = $this->postService->getActivePostByWithLimit(3);
        $comments = $this->commentService->getCommentsWithLimit(4);

        return view('dashboard', compact('dashboard', 'posts', 'comments'));
    }

    function home(): View
    {
        $posts = $this->postService->getPostForHomePage();
        return view('home', compact('posts'));
    }
}
