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
    return view('welcome');
});

Route::middleware("role:all")->group(function () {
    Route::prefix("post")->group(function () {
        Route::controller(PostController::class)->group(function () {
            Route::get('create', 'create')->name('post.create');
            Route::post('create', 'store')->name('post.store');
            Route::get('update', 'update')->name('post.update');
            Route::put('update', 'update')->name('post.store.update');
        });
    });
});

Route::middleware("role:admin")->group(function () {
    Route::prefix("post")->group(function () {
        Route::controller(PostController::class)->group(function () {
            Route::get('inquiry', 'inquiry')->name('post.inquiry');
            Route::get('detail/{id}', 'detail')->name('post.detail')
                ->where('id', '[0-9]+');
        });
    });
});


