<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Services\CategoryService;
use App\Services\CommonService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CategoryController extends Controller
{
    private CategoryService $categoryService;
    private CommonService $commonService;
    private string $controllerName = '[CategoryController] ';

    public function __construct(CategoryService $categoryService, CommonService $commonService)
    {
        $this->categoryService = $categoryService;
        $this->commonService = $commonService;
    }

    function create(): View
    {
        return view('category.create');
    }

    function view(string $id): View|RedirectResponse
    {
        $category = $this->categoryService->getCategoryById($id);
        return view('category.view', compact('category'));
    }

    function store(CategoryRequest $request): RedirectResponse
    {
        $this->generateStartLogMessage("create");

        try {
            $this->categoryService->save($request);
        } catch (Exception $e) {
            $errorMessage = $this->commonService->writeErrorLog($e);
            return redirect()->route('category.create')->with('error', $errorMessage);
        }

        $this->generateEndLogMessage("create", $request);
        return redirect()->route('category.create')->with('success', 'Category saved successfully!');
    }

    function edit_list(): View
    {
        $categories = $this->categoryService->getCategoryWithPage(10);
        return view('category.edit-list', compact('categories'));
    }

    function edit($id): View
    {
        $category = $this->categoryService->getCategoryById($id);
        return view('category.edit', compact('category'));
    }

    public function update(CategoryRequest $request): RedirectResponse
    {
        $this->generateStartLogMessage("update");

        try {
            $category = $this->categoryService->update($request);
        } catch (Exception $e) {
            $errorMessage = $this->commonService->writeErrorLog($e);
            return redirect()->route('category.edit', ['id' => $request->id])->with('error', $errorMessage);
        }

        $parameter = ['id' => $category->id];
        $this->generateEndLogMessage("update", $request);
        return redirect()->route('category.edit', $parameter)->with('success', 'Category updated successfully!');
    }

    function inquiry(): View
    {
        $categories = $this->categoryService->getCategoryWithPage(20);
        return view('category.inquiry', compact('categories'));
    }

    function generateStartLogMessage(string $method): void
    {
        $message = $this->controllerName . Auth::user()->name . " is trying to " . $method . " a category ...";
        $this->commonService->writeLog($message);
    }

    function generateEndLogMessage(string $method, CategoryRequest $request): void
    {
        $message = $this->controllerName . Auth::user()->name
            . " success " .$method. " a category with data : \n" . json_encode($request->all());
        $this->commonService->writeLog($message);
    }
}
