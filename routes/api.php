<?php

use Illuminate\Support\Facades\Route;

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


Route::get('/', function () {
    return [
        'api' => 'v-0.0.1',
        'provider' => 'irispass'
    ];
});

Route::get('filesystem/file', 'FileSystemController@serveFile');

Route::group(['middleware' => 'auth:api'], function () {


    Route::get('me', 'UserController@getCurrentUser');

    Route::put('settings', 'UserController@updateSettings');

    Route::get('me/groups', 'UserController@getUserGroups');

    Route::any('filesystem/{mount}/{method}', 'FileSystemController@handleRequests');

});







