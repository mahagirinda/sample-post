<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('home');
});

Route::middleware("role:all")->group(function () {
    Route::get("home", [PostController::class, 'home'])->name('home');
    Route::prefix("post")->group(function () {
        Route::controller(PostController::class)->group(function () {
            Route::get('create', 'create')->name('post.create');
            Route::post('create', 'store')->name('post.store');
            Route::get('user', 'user')->name('post.user');
            Route::get('view/{id}', 'view')->name('post.view');
        });
    });

    Route::prefix("comment")->group(function () {
        Route::controller(CommentController::class)->group(function () {
            Route::post('create', 'store')->name('comment.store');
            Route::get('user', 'user')->name('comment.user');
            Route::get('edit/{id}', 'edit')->name('comment.edit')
                ->where('id', '[0-9]+');
            Route::put('update', 'update')->name('comment.update');
        });
    });
});

Route::middleware("role:admin")->group(function () {
    Route::get("dashboard", [PostController::class, 'dashboard'])->name('dashboard');
    Route::prefix("post")->group(function () {
        Route::controller(PostController::class)->group(function () {
            Route::get('inquiry', 'inquiry')->name('post.inquiry');
            Route::get('edit-list', 'edit_list')->name('post.edit.list');
            Route::get('edit/{id}', 'edit')->name('post.edit')
                ->where('id', '[0-9]+');;
            Route::put('update', 'update')->name('post.update');
        });
    });

    Route::prefix("user")->group(function () {
        Route::controller(UserController::class)->group(function () {
            Route::get('inquiry', 'inquiry')->name('user.inquiry');
            Route::get('create', 'create')->name('user.create');
            Route::post('create', 'store')->name('user.store');
            Route::get('my-profile', 'profile')->name('user.profile');
            Route::get('edit-list', 'edit_list')->name('user.edit.list');
            Route::get('edit/{id}', 'edit')->name('user.edit')
                ->where('id', '[0-9]+');
            Route::put('update', 'update')->name('user.update');
        });
    });
});


