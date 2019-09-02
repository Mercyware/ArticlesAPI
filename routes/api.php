<?php

use Illuminate\Http\Request;

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


Route::post('login', 'AccountController@login')->name('login');
Route::post('register', 'AccountController@register')->name('register');
Route::get('logout', 'AccountController@logout')->name('logout')->middleware('auth:api');;

Route::prefix('articles')->group(function () {
    Route::get('', 'ArticleController@getArticles')->name('articles');
    Route::post('', 'ArticleController@createArticles')->name('articles.create')->middleware('auth:api');
    Route::get('{article_id}', 'ArticleController@getAnArticle')->name('article');
    Route::patch('{article_id}', 'ArticleController@updateArticle')->name('article.update')->middleware('auth:api');
    Route::delete('{article_id}', 'ArticleController@deleteArticle')->name('article.delete')->middleware('auth:api');
    Route::post('{article_id}/rating', 'ArticleController@rateArticle')->name('article.rate')->middleware('auth:api');

});

Route::get('/article/search', 'ArticleController@searchArticle')->name('article.search');

Route::fallback(function () {
    return response()->json(['message' => 'Not Found!'], 404);
});
