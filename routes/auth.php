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

/*
 * Authentication
 */
Route::get('keycloak/login', "AuthController@login");
Route::get('keycloak/authorize', "AuthController@authorizeUser");
Route::get('keycloak/callback', "AuthController@handleCallback");


Route::group(['middleware' => 'auth'], function () {

    /*
     * Authentication actions
     */
    Route::get('keycloak/profile', "AuthController@userProfile");
    Route::get('keycloak/logout', "AuthController@logout");

});



