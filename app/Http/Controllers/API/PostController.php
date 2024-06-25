<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\PostListResource;
use App\Http\Resources\PostResource;
use App\Services\PostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;

class PostController extends Controller
{
    private PostService $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Retrieve all posts with pagination.
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    function get_all_posts(Request $request): AnonymousResourceCollection
    {
        $perPage = $request->input('per_page', 10);
        $posts = $this->postService->getAllActivePostWithPaginate($perPage, 'desc');

        return PostListResource::collection($posts);
    }

    /**
     * Retrieve a single post by its ID.
     *
     * @param int $id
     * @return PostResource|JsonResponse
     */
    function get_post(int $id): PostResource|JsonResponse
    {
        $post = $this->postService->getPostById($id);
        if ($post) {
            return new PostResource($post);
        } else {
            return response()->json(['message' => 'Post not found'], 404);
        }
    }

}
