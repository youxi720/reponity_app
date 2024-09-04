<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::controller(UserController::class)->middleware(['auth'])->group(function(){
    Route::get('/users/{user}', 'show')->name('show');
    Route::put('/users/{user}', 'update')->name('update');
    Route::get('/users/{user}/edit', 'edit')->name('edit');
    Route::get('/postsubmit', 'thankspage')->name('thanks');
    Route::post('/users/{user}/postsubmit', 'countAnswers')->name('count-ans');
});

Route::controller(PostController::class)->middleware(['auth'])->group(function(){
    Route::get('/posts', 'post_index')->name('post_index');
    Route::get('/posts/create', 'post_create')->name('post_create');
    Route::post('/posts', 'post_store')->name('post_store');
    Route::get('/posts/my_posts', 'my_posts')->name('my_posts');
    Route::get('/posts/{post}', 'post_show')->name('post_show');
    Route::get('/posts/{post}/edit', 'post_edit')->name('post_edit');
    Route::put('/posts/{post}', 'post_update')->name('post_update');
    Route::delete('/posts/{post}', 'post_delete')->name('post_delete');  // 名前を統一
    Route::post('/posts/{post}/like', 'like')->name('like');
    Route::delete('/posts/{post}/like', 'unlike')->name('unlike');
    Route::get('/posts/like/show', 'likeshow')->name('likeshow');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
