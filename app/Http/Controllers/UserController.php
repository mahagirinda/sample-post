<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Services\CommonService;
use App\Services\UserService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserController extends Controller
{
    private UserService $userService;
    private CommonService $commonService;
    private string $controllerName = '[UserController] ';

    public function __construct(UserService $userService, CommonService $commonService)
    {
        $this->userService = $userService;
        $this->commonService = $commonService;
    }

    /**
     * Display a form to create a new user.
     *
     * @return View The view to create a new user.
     */
    function create(): View
    {
        return view('user.create');
    }

    /**
     * Display the profile of a specific user.
     *
     * @param string $id The ID of the user whose profile is to be displayed.
     * @return View The view displaying the profile of the specified user.
     */
    function user(string $id): View
    {
        $user = $this->userService->getUserProfileById($id);
        return view('user.view', compact('user'));
    }

    /**
     * Display the profile of the authenticated user.
     *
     * @return View The view displaying the profile of the authenticated user.
     */
    function profile(): View
    {
        $id = Auth::user()->id;
        $user = $this->userService->getUserProfileById($id);
        return view('user.profile', compact('user'));
    }

    /**
     * Update the profile of the authenticated user.
     *
     * @param UserRequest $request The incoming request containing the form data.
     * @return RedirectResponse A redirect response indicating success or failure.
     */
    public function profile_update(UserRequest $request): RedirectResponse
    {
        $this->generateStartLogMessage("update");

        try {
            $this->userService->update($request);
        } catch (Exception $e) {
            $errorMessage = $this->commonService->writeErrorLog($e);
            return redirect()->route('user.profile')->with('error', $errorMessage);
        }

        $this->generateEndLogMessage("update", $request);
        return redirect()->route('user.profile')->with('success', 'User updated successfully!');
    }

    /**
     * Store a newly created user.
     *
     * @param UserRequest $request The incoming request containing the form data.
     * @return RedirectResponse A redirect response indicating success or failure.
     */
    function store(UserRequest $request): RedirectResponse
    {
        $this->generateStartLogMessage("create");

        try {
            $this->userService->save($request);
        } catch (Exception $e) {
            $errorMessage = $this->commonService->writeErrorLog($e);
            return redirect()->route('user.create')->with('error', $errorMessage);
        }

        $this->generateEndLogMessage("create", $request);
        return redirect()->route('user.create')->with('success', 'User created successfully!');
    }

    /**
     * Display a list of users for editing.
     *
     * @return View The view displaying a list of users for editing.
     */
    function edit_list(): View
    {
        $users = $this->userService->getUsers(10);
        return view('user.edit-list', compact('users'));
    }

    /**
     * Display the edit form for a specific user.
     *
     * @param string $id The ID of the user to be edited.
     * @return View|RedirectResponse The view displaying the edit form or a redirect response if the user tries to edit themselves.
     */
    function edit(string $id): View | RedirectResponse
    {
        $user = $this->userService->getUserById($id);
        if (Auth::user()->id == $user->id) {
            return redirect()->route('home')->with('error', 'You cannot edit yourself from this menu!');
        }
        return view('user.edit', compact('user'));
    }

    /**
     * Update a user.
     *
     * This method handles the form submission to update a user's details.
     * It validates the incoming request using the UserRequest form request class, updates the user using the user service,
     * and logs the operation.
     *
     * @param UserRequest $request The incoming request containing the form data.
     * @return RedirectResponse A redirect response indicating success or failure.
     */
    public function update(UserRequest $request): RedirectResponse
    {
        $this->generateStartLogMessage("update");

        try {
            $user = $this->userService->update($request);
        } catch (Exception $e) {
            $errorMessage = $this->commonService->writeErrorLog($e);
            return redirect()->route('user.edit', ['id' => $request->id])->with('error', $errorMessage);
        }

        $parameter = ['id' => $user->id];
        $this->generateEndLogMessage("update", $request);
        return redirect()->route('user.edit', $parameter)->with('success', 'User updated successfully!');
    }

    /**
     * Display a list of users for inquiry.
     *
     * @return View The view displaying a list of users for inquiry.
     */
    function inquiry(): View
    {
        $users = $this->userService->getUsers(20);
        return view('user.inquiry', compact('users'));
    }

    /**
     * Generate a log message indicating the start of an action on a user.
     *
     * @param string $method The method name representing the action (e.g., create, update, delete).
     * @return void
     */
    function generateStartLogMessage(string $method): void
    {
        $message = $this->controllerName . Auth::user()->name . " is trying to " . $method . " an user ...";
        $this->commonService->writeLog($message);
    }

    /**
     * Generate a log message indicating the success of an action on a user.
     *
     * @param string $method The method name representing the action (e.g., create, update, delete).
     * @param UserRequest $request The incoming request containing the user data.
     * @return void
     */
    function generateEndLogMessage(string $method, UserRequest $request): void
    {
        $message = $this->controllerName . Auth::user()->name
            . " success " .$method. " an user with data : \n" . json_encode($request
                ->except('password', 'password_confirmation'));
        $this->commonService->writeLog($message);
    }
}
