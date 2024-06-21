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

    function create(): View
    {
        return view('user.create');
    }

    function user($id): View
    {
        $user = $this->userService->getUserProfileById($id);
        return view('user.view', compact('user'));
    }

    function profile(): View
    {
        $id = Auth::user()->id;
        $user = $this->userService->getUserProfileById($id);
        return view('user.profile', compact('user'));
    }

    public function profile_update (UserRequest $request): RedirectResponse
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

    function edit_list(): View
    {
        $users = $this->userService->getUsers(10);
        return view('user.edit-list', compact('users'));
    }

    function edit($id): View | RedirectResponse
    {
        $user = $this->userService->getUserById($id);
        if (Auth::user()->id == $user->id) {
            return redirect()->route('home')->with('error', 'You cannot edit yourself from this menu!');
        }
        return view('user.edit', compact('user'));
    }

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

    function inquiry(): View
    {
        $users = $this->userService->getUsers(20);
        return view('user.inquiry', compact('users'));
    }

    function generateStartLogMessage(string $method): void
    {
        $message = $this->controllerName . Auth::user()->name . " is trying to " . $method . " an user ...";
        $this->commonService->writeLog($message);
    }

    function generateEndLogMessage(string $method, UserRequest $request): void
    {
        $message = $this->controllerName . Auth::user()->name
            . " success " .$method. " an user with data : \n" . json_encode($request->all());
        $this->commonService->writeLog($message);
    }
}
