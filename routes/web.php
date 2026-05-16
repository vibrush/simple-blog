<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::get('/', [PostController::class, 'index']);

Route::middleware('auth')->group(function () {

    Route::get('/posts/create', [PostController::class, 'create']);

    Route::post('/posts', [PostController::class, 'store']);

    Route::get('/posts/{post}/edit', [PostController::class, 'edit']);

    Route::put('/posts/{post}', [PostController::class, 'update']);

    Route::delete('/posts/{post}', [PostController::class, 'destroy']);
});

Route::get('/posts/{post}', [PostController::class, 'show']);

Route::get('/dashboard', function () {
    return redirect('/');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
