<?php

use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\Backend\TrashController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\FeaturedStoryController;
use App\Http\Controllers\Api\ForgetPasswordController;
use App\Http\Controllers\Api\Frontend\FrontendController;
use App\Http\Controllers\Api\Frontend\SiteMapController;
use App\Http\Controllers\Api\GalleryController;
use App\Http\Controllers\Api\StoryController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\MediaLibraryController;
use App\Http\Controllers\Api\Frontend\AuthController;
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

    Route::group(['prefix' => 'public'], function () {
        Route::get('/categories', [FrontendController::class, 'allCategories']);
        Route::get('/latest/stories', [FrontendController::class, 'latestStories']);
        Route::get('/categories/{category}/stories', [FrontendController::class, 'categoryStories']);
        Route::get('/story/details/{story}', [FrontendController::class, 'storyDetails']);

        //Featured-stories--------
        Route::get('/categories/{category}/featured-stories', [FeaturedStoryController::class, 'categoryFeaturedStories']);

        //Social Login------------
        Route::post('/login', [AuthController::class, 'login']);       
        Route::post('/social-login', [AuthController::class, 'socialLogin']);
        Route::post('/register', [AuthController::class, 'register']); 
        
        //All stories for sitemap
        Route::group(['prefix' => 'sitemap'], function () {
          Route::get('/stories', [SiteMapController::class, 'sitemapStotries']);
        });
    });

    Route::post('/login', [UserController::class, 'login']);
    Route::post('/forgot-password', [ForgetPasswordController::class, 'forgotPassword']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/logout', [UserController::class, 'logout']);
        Route::apiResource('categories', CategoryController::class);
        Route::apiResource('authors', AuthorController::class);
        Route::apiResource('tags', TagController::class);
        Route::apiResource('stories', StoryController::class);

        //route::get('/image-upload', [GalleryController::class, 'imageUpload']);
        Route::post('/media-upload-image', [MediaLibraryController::class, 'uploadImage']);
        Route::get('/media-image-list', [MediaLibraryController::class, 'mediaImageList']);

        //Featured Stories------
        Route::get('/stories-search', [FeaturedStoryController::class, 'searchStories']);
        Route::post('/featured/stories/create', [FeaturedStoryController::class, 'createFeaturedStory']);

        //Trash----------------
        Route::get('/trash-items/{type}', [TrashController::class,'trashItems']);
        Route::put('/restore-trash-item/{type}/{id}', [TrashController::class,'restoreTrashItem']);
        Route::delete('/delete-trash-item/{type}/{id}', [TrashController::class,'deleteTrashItem']);

    });
});


