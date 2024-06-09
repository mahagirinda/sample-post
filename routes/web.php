<?php

use App\Http\Controllers\PostController;
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
});


