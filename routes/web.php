<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;

Route::get('/', [PostController::class, 'index'])->name('home');

Route::get('/post/{id}', [PostController::class, 'show'])->name('posts.show');

Route::get('/user/{id}/posts', [UserController::class, 'posts'])->name('users.posts');

Route::post('/post/{id}/react', [PostController::class, 'react'])->name('posts.react');