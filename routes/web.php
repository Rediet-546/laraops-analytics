<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
// Comment routes
Route::post('/posts/{post}/comments', [App\Http\Controllers\CommentController::class, 'store'])->name('comments.store')->middleware('auth');
Route::delete('/comments/{comment}', [App\Http\Controllers\CommentController::class, 'destroy'])->name('comments.destroy')->middleware('auth');?>