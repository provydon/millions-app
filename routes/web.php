<?php

use App\Helpers\Helper;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return ['Millions App' => app()->version()];
});


// Auth Routes
Route::get('login', function () {
    return Helper::apiRes("token is missing or has expired",[],false,401);
})->name('login');
