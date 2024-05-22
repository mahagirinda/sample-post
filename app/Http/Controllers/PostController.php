<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends Controller
{

    function create(): View
    {
        return view('post.create');
    }

    function store(Request $request): View
    {
        // PostModel::fill($request)->save();
        return view('post.create');
    }

    function update(): string
    {
        // return view('post.update');
        return redirect()->route('post.create');
    }

    function inquiry(): View
    {
        // $posts = PostModel::all();
        $posts = [
            (object)[
                "id" => 1,
                "title" => "Title 1",
                "body" => "Body 1"
            ],
            (object)[
                "id" => 2,
                "title" => "Title 2",
                "body" => "Body 2"
            ]
        ];

        // return view('post.inquiry', compact('posts'));
        return view('post.inquiry', [
            'posts' => $posts
        ]);
    }

    function detail($id): string
    {
        return view('post.detail', compact('id'));
    }
}
