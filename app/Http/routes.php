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
     * Authentication actions
     */
    Route::get('keycloak/profile', "AuthController@userProfile");
    Route::get('keycloak/logout', "AuthController@logout");

    /*
     * Organization creation ( access only on first login )
     */
    Route::get('organization/create', array('uses' => 'OrganizationController@create'));
    Route::post('organization', array('uses' => 'OrganizationController@store'));


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

            /*
             * User Group association
             */
            Route::post('manage/groups/{groupId}/add/{userId}', array('uses' => 'UsersGroupsController@addUserToGroup'));
            Route::post('manage/groups/{groupId}/remove/{userId}', array('uses' => 'UsersGroupsController@removeUserFromGroup'));
        });

    });

    /*
    * Admin Group
    */
    Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function () {

        /*
         * User resources
         */
        Route::get('users', 'UserController@index');
        Route::get('users/create', 'UserController@create');
        Route::get('users/create/quick', 'UserController@quickCreate');
        Route::post('users', 'UserController@store');
        Route::post('users/quick', 'UserController@quickStore');
        Route::get('users/{id}', 'UserController@show');
        Route::get('users/{id}/edit', 'UserController@edit');
        Route::put('users/{id}', 'UserController@update');
        Route::delete('users/{id}', 'UserController@destroy');

        Route::put('users/me/organization/{id}', 'UserController@switchOrganization');

        /*
         * Role resources
         */
        Route::get('roles', 'RoleController@index');
        Route::post('roles', 'RoleController@store');
        Route::get('roles/create', 'RoleController@create');
        Route::get('roles/{id}', 'RoleController@show');
        Route::get('roles/{id}/edit', 'RoleController@edit');
        Route::put('roles/{id}', 'RoleController@update');
        Route::delete('roles/{id}', 'RoleController@destroy');

        Route::put('roles/{id}/sync/permissions', 'RoleController@syncPermissions');

        /*
        * Permission resources
        */
        Route::post('permissions/trigger/scan', 'PermissionController@triggerScanPermission');

        Route::get('permissions', 'PermissionController@index');
        Route::post('permissions', 'PermissionController@store');
        Route::get('permissions/create', 'PermissionController@create');
        Route::get('permissions/{id}', 'PermissionController@show');
        Route::get('permissions/{id}/edit', 'PermissionController@edit');
        Route::put('permissions/{id}', 'PermissionController@update');
        Route::delete('permissions/{id}', 'PermissionController@destroy');

        Route::put('permissions/{id}/sync/roles', 'PermissionController@syncRoles');


        /*
         * Organizations resources
         */
        Route::get('organizations', 'OrganizationController@index');
        Route::get('organizations/create', 'OrganizationController@create');
        Route::post('organizations', 'OrganizationController@store');
        Route::get('organizations/{id}', 'OrganizationController@show');
        Route::get('organizations/{id}/edit', 'OrganizationController@edit');
        Route::put('organizations/{id}', 'OrganizationController@update');
        Route::delete('organizations/{id}', 'OrganizationController@destroy');

        /*
        * Licences resources
        */
        Route::get('licences', 'LicenceController@index');
        Route::get('licences/create', 'LicenceController@create');
        Route::post('licences', 'LicenceController@store');
        Route::get('licences/{id}', 'LicenceController@show');
        Route::get('licences/{id}/edit', 'LicenceController@edit');
        Route::put('licences/{id}', 'LicenceController@update');
        Route::delete('licences/{id}', 'LicenceController@destroy');

    });
});



