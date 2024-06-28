<?php

namespace App\Services;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserService
{
    public function getUsers($per_page)
    {
        return User::paginate($per_page);
    }

    public function countUsers(): int
    {
        return User::count();
    }

    public function getUserById($id)
    {
        return User::where('id', $id)->first();
    }

    public function getUserProfileById($id)
    {
        if (Auth::user()->id != $id) {
            return User::where('id', $id)->withCount('comments', 'posts')
                ->with(['posts' => function ($query) {
                    $query->where('draft', 0); // 0 : not on draft
                }])->first();
        }

        return User::where('id', $id)->withCount('comments', 'posts')->with('posts')->first();
    }

    public function save(UserRequest $request): void
    {
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
    }

    public function update(UserRequest $request)
    {
        $user = $this->getUserById($request->id);
        $user->name = $request->name;
        $user->email = $request->email ?? $user->email;
        $user->role = $request->role ?? $user->role;
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            if (Storage::disk('public')->exists('image/user/' . $user->image)) {
                if ($user->image != 'default.png') {
                    Storage::disk('public')->delete('image/user/' . $request->image);
                }
            }
            $imageName = time() . '.' . request()->image->getClientOriginalExtension();
            $request->file('image')->storeAs('image/user', $imageName, 'public');
            $user->image = $imageName;
        }
        $user->save();

        return $user;
    }
}
