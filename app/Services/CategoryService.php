<?php

namespace App\Services;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;

class CategoryService
{
    public function getActiveCategories()
    {
        return Category::where('status', 1)->orderBy('name', 'asc')->get();
    }

    public function getCategoryById($id)
    {
        return Category::where('id', $id)->first();
    }

    public function getCategoryWithPage($per_page)
    {
        return Category::withCount('posts')->paginate($per_page);
    }

    public function save(CategoryRequest $request): void
    {
        $category = new Category();
        $category->name = $request->name;
        $category->detail = $request->detail;
        $category->status = $request->status === "on";
        $category->save();
    }

    public function update(CategoryRequest $request)
    {
        $category = $this->getCategoryById($request->id);
        $category->name = $request->name;
        $category->detail = $request->detail;
        $category->status = $request->status === "on";
        $category->save();

        return $category;
    }
}
