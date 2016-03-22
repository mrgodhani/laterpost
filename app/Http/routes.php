<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

$api = app('Dingo\Api\Routing\Router');

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    Route::get('auth/twitter','\LaterPost\Api\AuthController@twitter');
    Route::get('auth/twitter/callback','\LaterPost\Api\AuthController@twitter_callback');
});

$api->version('v1', function ($api) {
    $api->post('login','LaterPost\Api\AuthController@login');
    $api->post('register','LaterPost\Api\AuthController@register');
    $api->get('refresh','LaterPost\Api\AuthController@refresh');
    $api->group(['middleware' => 'api.auth'],function($api){
        $api->get('users/current','LaterPost\Api\UserController@index');
        $api->delete('users','LaterPost\Api\UserController@destroy');
        $api->get('timezones','LaterPost\Api\UserController@timezone');
        $api->patch('timezone','LaterPost\Api\UserController@updateTimezone');
        $api->patch('password','LaterPost\Api\UserController@updatePassword');
        $api->patch('email','LaterPost\Api\UserController@updateEmail');
        $api->delete('accounts/{id}','LaterPost\Api\AccountController@deleteAccount');
        $api->post('posts','LaterPost\Api\PostController@store');
        $api->post('tweet','LaterPost\Api\PostController@tweet');
        $api->patch('posts','LaterPost\Api\PostController@update');
        $api->delete('posts','LaterPost\Api\PostController@delete');
    });
});

Route::any('{path?}', function () {
    return view('welcome');
})->where('path', '.+');