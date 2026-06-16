<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/posts', [TestController::class, 'getPosts']);
Route::get('/posts/{id}', [TestController::class, 'getPostById']);
Route::post('/posts', [TestController::class, 'createPost']);
Route::patch('/posts/{id}', [TestController::class, 'updatePost']);
Route::delete('/posts/{id}', [TestController::class, 'deletePost']);
