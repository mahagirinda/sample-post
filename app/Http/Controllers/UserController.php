<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class UserController extends Controller
{
    function create(): View
    {
        return view('user.create');
    }

    function profile(): View
    {
        // $id = Auth::user()->id;
        $id = '1';
        $user = User::where('id', $id)->get();
        return view('user.view', compact('user'));
    }

    function store(UserRequest $request): RedirectResponse
    {
        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->role = 'user';
            if ($request->hasFile('image')) {
                $imageName = time() . '.' . request()->image->getClientOriginalExtension();
                $request->file('image')->storeAs('image/user', $imageName, 'public');
                $user->image = $imageName;
            }
            $user->password = Hash::make($request->input('password'));
            $user->save();
        } catch (Exception $e) {
            Log::channel('log-error')->error($e->getMessage());
            return redirect()
                ->route('user.create')
                ->with('error', "Error : " . $e->getMessage());
        }

        return redirect()->route('user.create')->with('success', 'User created successfully!');
    }

    function edit_list(): View
    {
        $users = User::paginate(10);
        return view('user.edit-list', compact('users'));
    }

    function edit($id): View
    {
        $user = User::where('id', $id)->first();
        return view('user.edit', compact('user'));
    }

    public function update(UserRequest $request): RedirectResponse
    {
        $user = User::where('id', $request->id)->first();
        try {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->role = $request->role;
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                if (Storage::disk('public')->exists('image/user/' . $user->image)) {
                    if ($user->image != 'default.png') {
                        Storage::disk('public')->delete('image/user/' . $user->image);
                    }
                }
                $imageName = time() . '.' . request()->image->getClientOriginalExtension();
                $request->file('image')->storeAs('image/user', $imageName, 'public');
                $user->image = $imageName;
            }
            $user->save();
        } catch (Exception $e) {
            Log::channel('log-error')->error($e->getMessage());
            return redirect()
                ->route('user.edit', ['id' => $user->id])
                ->with('error', "Error : " . $e->getMessage());
        }

        $parameter = ['id' => $user->id];
        return redirect()->route('user.edit', $parameter)->with('success', 'User updated successfully!');
    }

    function inquiry(): View
    {
        $users = User::paginate(10);
        return view('user.inquiry', compact('users'));
    }
}
