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


//Organization
Route::group(['prefix' => 'organization'], function () {
    Route::get('/', array('uses' => 'OrganizationController@index'));
    Route::get('/create', array('uses' => 'OrganizationController@create'));
    Route::post('/', array('uses' => 'OrganizationController@store'));
    Route::get('edit', array('uses' => 'OrganizationController@edit'));
    Route::patch('edit', array('uses' => 'OrganizationController@update'));
});

//Users
Route::group(['prefix' => 'management'], function () {

    Route::get('/', array('uses' => 'UsersManagementController@index'));

    Route::get('users/create', array('uses' => 'UsersController@create'));
    Route::post('users', array('uses' => 'UsersController@store'));
    Route::get('users/{id}', array('uses' => 'UsersController@show'));
    Route::get('users/{id}/edit', array('uses' => 'UsersController@edit'));
    Route::patch('users/{id}/edit', array('uses' => 'UsersController@update'));
    Route::delete('users/{id}', array('uses' => 'UsersController@destroy'));

    Route::get('groups/create', array('uses' => 'GroupsController@create'));
    Route::post('groups', array('uses' => 'GroupsController@store'));
    Route::get('groups/{id}', array('uses' => 'GroupsController@show'));
    Route::get('groups/{id}/edit', array('uses' => 'GroupsController@edit'));
    Route::patch('groups/{id}/edit', array('uses' => 'GroupsController@update'));
    Route::delete('groups/{id}', array('uses' => 'GroupsController@destroy'));

    Route::post('manage/groups/{groupId}/add/{userId}', array('uses' => 'UsersGroupsController@addUserToGroup'));
    Route::post('manage/groups/{groupId}/remove/{userId}', array('uses' => 'UsersGroupsController@removeUserFromGroup'));

});