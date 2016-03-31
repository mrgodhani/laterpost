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
    Route::get('auth/bitly','\LaterPost\Api\AuthController@bitly');
    Route::get('auth/twitter/callback','\LaterPost\Api\AuthController@twitter_callback');
    Route::get('auth/bitly/callback','\LaterPost\Api\AuthController@bitly_callback');
});

$api->version('v1', function ($api) {
    $api->post('login','LaterPost\Api\AuthController@login');
    $api->post('register','LaterPost\Api\AuthController@register');
    $api->get('refresh','LaterPost\Api\AuthController@refresh');
    $api->post('reset','LaterPost\Api\AuthController@reset');
    $api->post('passwordreset','LaterPost\Api\AuthController@postReset');
    $api->group(['middleware' => 'api.auth'],function($api){
        $api->get('users/current','LaterPost\Api\UserController@index');
        $api->delete('users','LaterPost\Api\UserController@destroy');
        $api->get('timezones','LaterPost\Api\UserController@timezone');
        $api->patch('timezone','LaterPost\Api\UserController@updateTimezone');
        $api->patch('password','LaterPost\Api\UserController@updatePassword');
        $api->patch('shortener','LaterPost\Api\UserController@updateShortener');
        $api->patch('email','LaterPost\Api\UserController@updateEmail');
        $api->delete('accounts/bitly','LaterPost\Api\AccountController@deleteBitly');
        $api->delete('accounts/{id}','LaterPost\Api\AccountController@deleteAccount');
        $api->get('posts/{id}/image','LaterPost\Api\PostController@getImage');
        $api->post('posts','LaterPost\Api\PostController@store');
        $api->post('shorten','LaterPost\Api\PostController@shorten');
        $api->post('tweet','LaterPost\Api\PostController@tweet');
        $api->post('posts/{id}','LaterPost\Api\PostController@update');
        $api->delete('posts','LaterPost\Api\PostController@delete');
    });
});

Route::any('{path?}', function () {
    return view('welcome');
})->where('path', '.+');