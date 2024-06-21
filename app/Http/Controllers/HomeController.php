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

    /**
     * Display the dashboard view with summary data.
     *
     * This method retrieves summary counts for posts, users, and comments from their respective services.
     * It also fetches a limited number of active posts and comments for display on the dashboard.
     * The method then returns the 'dashboard' view with the retrieved data.
     *
     * @return View The view displaying the dashboard with summary data and limited posts and comments.
     */
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

    /**
     * Display the home page view with posts.
     *
     * This method retrieves posts intended for display on the home page from the post service.
     * It then returns the 'home' view with the retrieved posts.
     *
     * @return View The view displaying the home page with posts.
     */
    function home(): View
    {
        $posts = $this->postService->getPostForHomePage();
        return view('home', compact('posts'));
    }
}
