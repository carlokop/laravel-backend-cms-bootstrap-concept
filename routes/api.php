<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});




Route::group(['middleware' => ['api'],'namespace' => 'Admin'] , function() {

    /* Slugs */

    Route::get('/slugs', 'AdminSlugController@slugs');

    Route::get('/slugs/{path}', 'AdminSlugController@sanatise');

    /* Posts */

    Route::get('/categories', 'AdminPostCategoryController@categoriesApi');

    Route::get('/category/{id}', 'AdminPostCategoryController@categoryApi');

    /* Images */

    Route::get('/media', 'AdminMediaController@allImagesApi');

    Route::get('/media/upload/', 'AdminMediaController@mediaupload');

    Route::get('/media/{id}', 'AdminMediaController@imageApi');

    /* Comments */

    Route::get('/comments/{id}', 'AdminCommentController@commentApi');


});