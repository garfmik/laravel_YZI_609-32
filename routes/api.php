<?php

use App\Http\Controllers\RestaurantControllerApi;
use App\Http\Controllers\ReviewControllerApi;
use App\Http\Controllers\UserControllerApi;
use Illuminate\Support\Facades\Route;

Route::get('/restaurants', [RestaurantControllerApi::class, 'index']);
Route::get('/restaurants/{id}', [RestaurantControllerApi::class, 'show']);

Route::get('/restaurants/{restaurant}/reviews', [ReviewControllerApi::class, 'index']);
Route::get('/reviews/{review}', [ReviewControllerApi::class, 'show']);


Route::get('/users/{id}', [UserControllerApi::class, 'show']);
