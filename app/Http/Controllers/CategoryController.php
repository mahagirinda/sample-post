<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class CategoryController extends Controller
{
    function create(): View
    {
        return view('category.create');
    }

    function view(string $id): View|RedirectResponse
    {
        $category = Category::where('id', $id)->with('posts')->first();
        return view('category.view', compact('category'));
    }

    function store(CategoryRequest $request): RedirectResponse
    {
        try {
            $category = new Category();
            $category->name = $request->name;
            $category->detail = $request->detail;
            $category->status = $request->status === "on";
            $category->save();
        } catch (Exception $e) {
            Log::channel('log-error')->error($e->getMessage());
            return redirect()
                ->route('category.create')
                ->with('error', "Error : " . $e->getMessage());
        }

        return redirect()->route('category.create')->with('success', 'Category saved successfully!');
    }

    function edit_list(): View
    {
        $categories = Category::withCount('posts')->paginate(10);
        return view('category.edit-list', compact('categories'));
    }

    function edit($id): View
    {
        $category = Category::where('id', $id)->first();
        return view('category.edit', compact('category'));
    }

    public function update(CategoryRequest $request): RedirectResponse
    {
        $category = Category::where('id', $request->id)->first();
        try {
            $category->name = $request->name;
            $category->detail = $request->detail;
            $category->status = $request->status === "on";
            $category->save();
        } catch (Exception $e) {
            Log::channel('log-error')->error($e->getMessage());
            return redirect()
                ->route('category.edit', ['id' => $category->id])
                ->with('error', "Error : " . $e->getMessage());
        }

        $parameter = ['id' => $category->id];
        return redirect()->route('category.edit', $parameter)->with('success', 'Category updated successfully!');
    }

    function inquiry(): View
    {
        $categories = Category::withCount('posts')->paginate(20);
        return view('category.inquiry', compact('categories'));
    }
}
