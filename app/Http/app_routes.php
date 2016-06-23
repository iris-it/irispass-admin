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

use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@index');

Route::group(['prefix' => 'keycloak'], function () {
    Route::get('login', "AuthController@login");
    Route::get('authorize', "AuthController@authorizeUser");
    Route::get('callback', "AuthController@handleCallback");
    Route::get('profile', "AuthController@userProfile");
    Route::get('logout', "AuthController@logout");
});
