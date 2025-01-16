<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//no need to authenticate
Route::post(uri: '/register',action: [AuthController::class, 'register']);

Route::post(uri: '/login',action: [AuthController::class, 'login']);

Route::get('/all/posts',[PostController::class,'getAllPosts']);
Route::get('/single/post/{post_id}',[PostController::class,'getPost']);

// get all posts no need to authenticate
Route::middleware('auth:sanctum')->group(function(){
    Route::post('/logout',[AuthController::class, 'logout']);

   //blog api

Route::post('/add/post', [PostController::class,'addNewPost']);

//edit approach 1
Route::post('/edit/post', [PostController::class,'editPost']);
// delete post

Route::post('/delete/post/{post_id}', [PostController::class,'deletePost']);

Route::post('/edit/post/{post_id}', [PostController::class,'editPost2']);
});
// Route::post('/add/post', [PostController::class,'addNewPost'
