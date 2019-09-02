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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('articles')->group(function () {
    Route::get('', 'ArticleController@getArticles')->name('articles');
    Route::post('', 'ArticleController@createArticles')->name('articles.create');
    Route::get('{article_id}', 'ArticleController@getAnArticle')->name('article');
    Route::patch('{article_id}', 'ArticleController@updateArticle')->name('article.update');
    Route::delete('{article_id}', 'ArticleController@deleteArticle')->name('article.delete');
    Route::post('{article_id}/rating', 'ArticleController@rateArticle')->name('article.rate');

});

Route::get('/article/search', 'ArticleController@searchArticle')->name('article.search');

Route::fallback(function(){
    return response()->json(['message' => 'Not Found!'], 404);
});
