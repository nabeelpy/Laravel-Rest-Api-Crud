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


Route::post('/register',[\App\Http\Controllers\AuthController::class, 'register']);
Route::post('/login',[\App\Http\Controllers\AuthController::class, 'login']);

Route::get('/products',[\App\Http\Controllers\ProductController::class, 'index']);
Route::post('/products',[\App\Http\Controllers\ProductController::class, 'store']);
Route::post('/products/{id}',[\App\Http\Controllers\ProductController::class, 'show']);
Route::post('/update/{id}',[\App\Http\Controllers\ProductController::class, 'update']);  //use put
Route::post('/delete/{id}',[\App\Http\Controllers\ProductController::class, 'destroy']);



Route::group(['middleware'=>['auth:sanctum']], function () {
    Route::post('/search/{name}',[\App\Http\Controllers\ProductController::class, 'search']);
    Route::post('/logout',[\App\Http\Controllers\AuthController::class, 'logout']);
});


