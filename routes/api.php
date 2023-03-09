<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use \App\Http\Controllers\BannerController;
use App\Http\Controllers\CardItemController;


Route::group(['middleware' => ['auth:sanctum']] , function () {
    Route::post('/logout' , [AuthController::class , 'logout']);
    //Role Route
    Route::get('/roles' , [RoleController::class  , 'index']);
    Route::post('/roles' , [RoleController::class  , 'store']);
    //Category Route
    Route::get('/categories' , [CategoryController::class , 'index']);
    Route::post('/categories' , [CategoryController::class , 'store']);
    Route::patch('/categories/{category}' , [CategoryController::class , 'update']);
    Route::delete('/categories/{category}' , [CategoryController::class , 'destroy']);
    //Size Route
    Route::get('/sizes' , [SizeController::class , 'index']);
    Route::post('/sizes' , [SizeController::class , 'store']);
    Route::patch('sizes/{size}' , [SizeController::class , 'update']);
    Route::delete('/sizes/{size}' , [SizeController::class , 'destroy']);

    //Review Route
    Route::get('/reviews' , [ReviewController::class , 'index']);
    Route::post('/reviews' , [ReviewController::class , 'store']);
    Route::delete('reviews/{review}' , [ReviewController::class , 'destroy']);
    Route::patch('/reviews/like/{review}' , [ReviewController::class , 'like']);
    // User Controller
    Route::get('/users' ,[UserController::class , 'index' ]);
    Route::patch('/users/{user}' ,[ UserController::class , 'update' ]);
    Route::post('/users/{user}/update_image' ,[ UserController::class , 'updateImage' ]);
    Route::get('users/profile' , [UserController::class , 'profile']);

    //Product Route
    Route::get('/products' , [ProductController::class , 'index']);
    Route::post('/products' , [ProductController::class , 'store']);
    Route::patch('/products/{product}' , [ProductController::class , 'update']);
    Route::delete('/products/{product}' , [ProductController::class , 'destroy']);
    Route::patch('/products/like/{product}' , [ProductController::class , 'like']);

    //Banner Route
    Route::get('/banners' , [BannerController::class , 'index']);
    Route::post('/banners' , [BannerController::class , 'store']);
    Route::patch('/banners/{banner}' , [BannerController::class , 'update']);
    Route::delete('/banners/{banner}' , [BannerController::class , 'destroy']);

    // Card_Item Route
    Route::get('/cardItems' , [CardItemController::class , 'index']);
    Route::post('/cardItems' , [CardItemController::class , 'store']);
    Route::patch('/cardItems/{cardItem}' , [CardItemController::class , 'update']);
    Route::delete('/cardItems/{cardItem}' , [CardItemController::class , 'destroy']);
});
// Auth Controller

Route::post('/register' , [AuthController::class , 'register'] );
Route::post('/login' , [AuthController::class , 'login']);






