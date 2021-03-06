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
    return redirect('/home');
});


/*
|--------------------------------------------------------------------------
| API routes
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'api', 'namespace' => 'API'], function () {
    Route::group(['prefix' => 'v1'], function () {
        require config('infyom.laravel_generator.path.api_routes');
    });
});


Route::auth();

Route::get('/home', 'HomeController@search');

Route::auth();


Route::resource('/', 'HomeController');
Route::get('/home', 'HomeController@search');
Route::get('/hue', 'HueController@home');
Route::get('/netatmo', 'NetatmoController@index');
Route::get('/netatmo/redir', 'NetatmoController@redir');
Route::get('/netatmo/webhook', 'NetatmoController@webhook');
Route::get('/netatmo/test','NetatmoController@test');
Route::get('/hue/apagar/{id}','HueController@apagar');
Route::get('/hue/prender/{id}','HueController@prender');