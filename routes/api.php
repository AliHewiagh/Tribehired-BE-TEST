<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::get('/posts/top', [PostController::class, 'index']);


Route::get('/comments', [CommentController::class, 'index']);


Route::get('/comments/search', [CommentController::class, 'filter']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
