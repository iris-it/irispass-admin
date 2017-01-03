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
|--------------------------------------------------------------------------
| Application pages
|--------------------------------------------------------------------------
|
*/

Route::group(['middleware' => 'auth'], function () {

    /*
     * Homepage
     */
    Route::get('/', 'HomeController@index');

    /*
     * Organization creation ( access only on first login )
     */
    Route::get('organization/create', array('uses' => 'OrganizationController@create'));
    Route::post('organization/store', array('uses' => 'OrganizationController@store'));


    Route::group(['middleware' => 'hasOrganization'], function () {

        /*
         * Organization resources
         */
        Route::get('organization', array('uses' => 'OrganizationController@index'));
        Route::get('organization/edit', array('uses' => 'OrganizationController@edit'));
        Route::patch('organization/edit', array('uses' => 'OrganizationController@update'));


        /*
         * User Group Management
         */
        Route::group(['prefix' => 'management'], function () {

            /*
             * Overview
             */
            Route::get('/', array('uses' => 'UsersManagementController@index'));

            /*
             * User resources
             */
            Route::get('users/create', array('uses' => 'UsersController@create'));
            Route::post('users', array('uses' => 'UsersController@store'));
            Route::get('users/{id}', array('uses' => 'UsersController@show'));
            Route::get('users/{id}/edit', array('uses' => 'UsersController@edit'));
            Route::patch('users/{id}/edit', array('uses' => 'UsersController@update'));
            Route::delete('users/{id}', array('uses' => 'UsersController@destroy'));

            /*
             * Group resources
             */
            Route::get('groups/create', array('uses' => 'GroupsController@create'));
            Route::post('groups', array('uses' => 'GroupsController@store'));
            Route::get('groups/{id}', array('uses' => 'GroupsController@show'));
            Route::get('groups/{id}/edit', array('uses' => 'GroupsController@edit'));
            Route::patch('groups/{id}/edit', array('uses' => 'GroupsController@update'));
            Route::delete('groups/{id}', array('uses' => 'GroupsController@destroy'));
            Route::post('manage/groups/{groupId}/add/{userId}', array('uses' => 'GroupsController@addUserToGroup'));
            Route::post('manage/groups/{groupId}/remove/{userId}', array('uses' => 'GroupsController@removeUserFromGroup'));
        });


        Route::group(['prefix' => 'website'], function () {
            Route::get('/', array('uses' => 'WebsiteController@index'));
            Route::get('create', array('uses' => 'WebsiteController@create'));
            Route::post('create', array('uses' => 'WebsiteController@store'));
            Route::delete('delete', array('uses' => 'WebsiteController@destroy'));
        });

    });

});



