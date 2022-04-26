<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LikeController;
use App\Http\Controllers\Api\PostController;
use App\Http\Resources\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Auth Routes
Route::post('login', [AuthController::class, 'login'])->middleware("validate:login");
Route::post('register', [AuthController::class, 'register'])->middleware("validate:register");

// Post Routes
Route::resource('posts', PostController::class);
Route::get('posts/{post}/likes', [PostController::class, 'likes']);

// Logged In Routes
Route::middleware(['auth:sanctum'])->group(function () {

    // User Routes
    Route::get('/user', [AuthController::class, 'user']);

    // Post Routes
    Route::get('like-post', [PostController::class, 'like'])->middleware("validate:like-post");
    Route::get('unlike-post', [PostController::class, 'unLike'])->middleware("validate:like-post");

});
