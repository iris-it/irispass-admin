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



