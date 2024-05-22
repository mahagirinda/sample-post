<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    function create() : string
    {
        return "ini adalah halaman post create";
    }

    function update() : string
    {
        return redirect()->route('post.create');
    }

    function inquiry() : string
    {
        return "ini adalah halaman post inquiry";
    }

    function detail($id) : string
    {
        return "ini adalah halaman post  untuk id : " . $id;
    }
}
