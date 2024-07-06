<?php

use App\Http\Controllers\AdController;
use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\Backend\TrashController;
use App\Http\Controllers\Api\Backend\TrendyTopicController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\FeaturedStoryController;
use App\Http\Controllers\Api\RecommendedStoryController;
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

        //Preview-story---------
        Route::get('/preview-story/{story}', [FrontendController::class, 'previewStory']);

        //Featured-stories--------
        Route::get('/categories/{category}/featured-stories', [FrontendController::class, 'categoryFeaturedStories']);

        //Recommended-stories--------
        Route::get('/recommended-stories', [FrontendController::class, 'recommendedStories']);

        //Trending-stories--------
        Route::get('/trendy-topics', [FrontendController::class, 'trendyTopics']);
        Route::get('/topic/{tag}', [FrontendController::class, 'trendingTopicStories']);

        //Related-stories-------
        Route::get('/related-stories', [FrontendController::class, 'relatedStories']);
        
        //Social Login------------
        Route::post('/login', [AuthController::class, 'login']);       
        Route::post('/social-login', [AuthController::class, 'socialLogin']);
        Route::post('/register', [AuthController::class, 'register']); 
        
        //All stories for sitemap
        Route::group(['prefix' => 'sitemap'], function () {
          Route::get('/stories', [SiteMapController::class, 'sitemapStotries']);
        });

        //Author details-------
        Route::get('/author-details/{author}', [FrontendController::class, 'authorDetails']); 
        
        //Stories of author-----------
        Route::get('/author-stories/{author}', [FrontendController::class, 'authorStories']); 

        //Get ads------------
        Route::get('/ads', [AdController::class, 'getAdsByPage']);
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

        // Trendy topic -----
        Route::get('/trendy-topic-search', [TrendyTopicController::class, 'searchTrendyTopic']);
        Route::post('/trendy-topic/create', [TrendyTopicController::class, 'createTrendyTopic']);

        //Recommended Stories---------
        // Route::get('/stories-search', [RecommendedStoryController::class, 'searchStories']);
        Route::post('/recommended-stories/create', [RecommendedStoryController::class, 'createRecommendedStory']);

        //Trash----------------
        Route::get('/trash-items/{type}', [TrashController::class,'trashItems']);
        Route::put('/restore-trash-item/{type}/{id}', [TrashController::class,'restoreTrashItem']);
        Route::delete('/delete-trash-item/{type}/{id}', [TrashController::class,'deleteTrashItem']);

        //Store ads---------------
        Route::post('/ads', [AdController::class, 'store']);

    });
});


