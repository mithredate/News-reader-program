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

Route::get('/', function () {
    return view('welcome');
});

Route::get('verify/{token?}','Auth\AuthController@verify');

Route::post('set-password','Auth\AuthController@setPassword');

Route::auth();

Route::get('/home', 'HomeController@index');
