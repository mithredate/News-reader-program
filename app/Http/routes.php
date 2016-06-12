<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'HomeController@index');

Route::get('verify/{token?}','Auth\AuthController@verify');

Route::post('set-password','Auth\AuthController@setPassword');

Route::auth();


Route::group(['prefix' => 'home', 'middleware' => ['web', 'auth']], function(){
    Route::resource('articles','NewsArticleController');
    Route::get('/', 'HomeController@index');
});

Route::get('gallery/{path}', 'ImageController@output')->where('path', '.+');

Route::get('/{slug}', ['as' => 'articles.show', 'uses' => 'NewsController@show']);