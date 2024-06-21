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

    /**
     * Show the form for creating a new category.
     *
     * @return View The view that contains the form for creating a new category.
     */
    function create(): View
    {
        return view('category.create');
    }

    /**
     * Display the specified category.
     *
     * @param string $id The ID of the category to display.
     * @return View|RedirectResponse The view displaying the category details
     * or a redirect response if the category is not found.
     */
    function view(string $id): View|RedirectResponse
    {
        $category = $this->categoryService->getCategoryById($id);
        return view('category.view', compact('category'));
    }

    /**
     * Store a newly created category.
     *
     * @param CategoryRequest $request The incoming request containing the form data.
     * @return RedirectResponse A redirect response indicating success or failure.
     */
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

    /**
     * Display a listing of categories for editing.
     *
     * @return View The view displaying the list of categories for editing.
     */
    function edit_list(): View
    {
        $categories = $this->categoryService->getCategoryWithPage(10);
        return view('category.edit-list', compact('categories'));
    }

    /**
     * Show the form for editing the specified category.
     *
     * @param string $id The ID of the category to edit.
     * @return View The view displaying the form to edit the category details.
     */
    function edit($id): View
    {
        $category = $this->categoryService->getCategoryById($id);
        return view('category.edit', compact('category'));
    }

    /**
     * Update the specified category.
     *
     * @param CategoryRequest $request The incoming request containing the form data.
     * @return RedirectResponse A redirect response indicating success or failure.
     */
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

    /**
     * Display a listing of categories for inquiry.
     *
     * @return View The view displaying the list of categories for inquiry.
     */
    function inquiry(): View
    {
        $categories = $this->categoryService->getCategoryWithPage(20);
        return view('category.inquiry', compact('categories'));
    }

    /**
     * Generate the start log message for a category operation.
     *
     * @param string $method The method of the category operation (e.g., create, update).
     * @return void
     */
    function generateStartLogMessage(string $method): void
    {
        $message = $this->controllerName . Auth::user()->name . " is trying to " . $method . " a category ...";
        $this->commonService->writeLog($message);
    }

    /**
     * Generate the end log message for a category operation.
     *
     * @param string $method The method of the category operation (e.g., create, update).
     * @param CategoryRequest $request The incoming request containing the form data.
     * @return void
     */
    function generateEndLogMessage(string $method, CategoryRequest $request): void
    {
        $message = $this->controllerName . Auth::user()->name
            . " success " .$method. " a category with data : \n" . json_encode($request->all());
        $this->commonService->writeLog($message);
    }
}
