<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\authController;
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
Route::post('register', [authController::class, 'register']);
Route::post('login', [authController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function(){

Route::get('user-profile', [authController::class, 'userProfile']);
Route::post('logout', [authController::class, 'loguot']);
Route::get('all-users', [authController::class, 'allUsers']);
});
