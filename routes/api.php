<?php

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([], function () {
    Route::post('/user/register', [\App\Http\Controllers\User\UserController::class, 'register']);
    Route::post('/auth/token', [\App\Http\Controllers\Auth\AuthController::class, 'token']);
});

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/user/option/edit', [\App\Http\Controllers\User\UserOptionController::class, 'edit']);
});

