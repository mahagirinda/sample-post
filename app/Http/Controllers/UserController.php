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

    public function __construct(UserService $userService, CommonService $commonService)
    {
        $this->userService = $userService;
        $this->commonService = $commonService;
    }

    function create(): View
    {
        return view('user.create');
    }

    function profile(): View
    {
        $id = Auth::user()->id;
        $user = $this->userService->getUserById($id);
        return view('user.view', compact('user'));
    }

    function store(UserRequest $request): RedirectResponse
    {
        try {
            $this->userService->save($request);
        } catch (Exception $e) {
            $errorMessage = $this->commonService->writeErrorLog($e);
            return redirect()->route('user.create')->with('error', $errorMessage);
        }

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
        try {
            $user = $this->userService->update($request);
        } catch (Exception $e) {
            $errorMessage = $this->commonService->writeErrorLog($e);
            return redirect()->route('user.edit', ['id' => $request->id])->with('error', $errorMessage);
        }

        $parameter = ['id' => $user->id];
        return redirect()->route('user.edit', $parameter)->with('success', 'User updated successfully!');
    }

    function inquiry(): View
    {
        $users = $this->userService->getUsers(20);
        return view('user.inquiry', compact('users'));
    }
}
