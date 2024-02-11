<?php

use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ForgetPasswordController;
use App\Http\Controllers\Api\GalleryController;
use App\Http\Controllers\Api\StoryController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\MediaLibraryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::group(['prefix'=>'v1'], function () {
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/forgot-password', [ForgetPasswordController::class, 'forgotPassword']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/logout', [UserController::class, 'logout']);
        Route::apiResource('categories', CategoryController::class);
        Route::apiResource('authors', AuthorController::class);
        Route::apiResource('tags', TagController::class);
        Route::apiResource('stories', StoryController::class);
        //route::post('/image-upload', [GalleryController::class, 'imageUpload']);
        Route::post('/media-upload-image', [MediaLibraryController::class, 'uploadImage']);
        Route::get('/media-image-list', [MediaLibraryController::class, 'mediaImageList']);
    });
});


