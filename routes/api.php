<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FavouriteControllerApi;
use App\Http\Controllers\RestaurantControllerApi;
use App\Http\Controllers\ReviewControllerApi;
use App\Http\Controllers\UserControllerApi;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::post('/login', [AuthController::class, 'login']);

Route::get('/restaurants', [RestaurantControllerApi::class, 'index']);

Route::get('/restaurants/{id}', [RestaurantControllerApi::class, 'show']);


Route::get('/restaurants_total', [RestaurantControllerApi::class, 'total']);

Route::get('/reviews/{id}', [ReviewControllerApi::class, 'show']);
Route::get('/users/{id}', [UserControllerApi::class, 'show']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/favourites', [FavouriteControllerApi::class, 'index']);
    Route::get('/favourites_total', [FavouriteControllerApi::class, 'total']);
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/restaurants/{id}/reviews', [ReviewControllerApi::class, 'index']);
    Route::get('/user',function (Request $request){
        return $request->user();
    });
    Route::get('/logout', [AuthController::class, 'logout']);
});
