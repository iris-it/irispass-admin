<?php
/**
 * Created by PhpStorm.
 * User: monkey_C
 * Date: 02-Feb-16
 * Time: 11:33 PM
 */

// Organisation
Breadcrumbs::register('organization', function ($breadcrumbs) {
    $breadcrumbs->push(trans('breadcrumbs.organization'), action('OrganizationController@index'));
});

// Organisation > Edit
Breadcrumbs::register('organization_edit', function ($breadcrumbs) {
    $breadcrumbs->parent('organization');
    $breadcrumbs->push(trans('breadcrumbs.organization-edit'), action('OrganizationController@edit'));
});

// Organisation > Create
Breadcrumbs::register('organization_create', function ($breadcrumbs) {
    $breadcrumbs->parent('organization');
    $breadcrumbs->push(trans('breadcrumbs.organization-create'), action('OrganizationController@create'));
});


// usersmanagement
Breadcrumbs::register('usersmanagement', function ($breadcrumbs) {
    $breadcrumbs->push(trans('breadcrumbs.usersmanagement'), action('UsersManagementController@index'));
});

// usersmanagement > Create group
Breadcrumbs::register('create_group', function ($breadcrumbs) {
    $breadcrumbs->parent('usersmanagement');
    $breadcrumbs->push(trans('breadcrumbs.group-creation'), action('GroupsController@create'));
});

// usersmanagement > Create user
Breadcrumbs::register('create_user', function ($breadcrumbs) {
    $breadcrumbs->parent('usersmanagement');
    $breadcrumbs->push(trans('breadcrumbs.user-creation'), action('UsersController@create'));
});


// usersmanagement > Show group
Breadcrumbs::register('show_group', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('usersmanagement');
    $breadcrumbs->push(trans('breadcrumbs.show-group'), action('GroupsController@show', $id));
});

// usersmanagement > Show user
Breadcrumbs::register('show_user', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('usersmanagement');
    $breadcrumbs->push(trans('breadcrumbs.show-user'), action('UsersController@show', $id));
});


// usersmanagement > Edit group
Breadcrumbs::register('edit_group', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('usersmanagement', $id);
    $breadcrumbs->push(trans('breadcrumbs.edit-group'), action('GroupsController@edit', $id));
});

// usersmanagement > Edit user
Breadcrumbs::register('edit_user', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('usersmanagement', $id);
    $breadcrumbs->push(trans('breadcrumbs.edit-user'), action('UsersController@edit', $id));
});


//////////////////////////////////////////////////////////////////////////////////////////////
///////////////////                 ADMIN SECTION                        /////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////

//TODO Find better names

// Users
Breadcrumbs::register('users', function ($breadcrumbs) {
    $breadcrumbs->push(trans('breadcrumbs.users'), action('Admin\UserController@index'));
});

// Users > Form
Breadcrumbs::register('user-form', function ($breadcrumbs) {
    $breadcrumbs->parent('users');
    $breadcrumbs->push(trans('breadcrumbs.data'));
});

// Users > Show
Breadcrumbs::register('user-show', function ($breadcrumbs, $user) {
    $breadcrumbs->parent('users');
    $breadcrumbs->push($user->username, action('Admin\UserController@show', $user->id));
});

// Role
Breadcrumbs::register('roles', function ($breadcrumbs) {
    $breadcrumbs->push('Roles', action('Admin\RoleController@index'));
});

// Role > Form
Breadcrumbs::register('role-form', function ($breadcrumbs) {
    $breadcrumbs->parent('roles');
    $breadcrumbs->push(trans('breadcrumbs.data'));
});

// Role > Show
Breadcrumbs::register('role-show', function ($breadcrumbs, $role) {
    $breadcrumbs->parent('roles');
    $breadcrumbs->push($role->name, action('Admin\PermissionController@show', $role->id));
});


// Permission
Breadcrumbs::register('permissions', function ($breadcrumbs) {
    $breadcrumbs->push(trans('breadcrumbs.permissions'), action('Admin\PermissionController@index'));
});

// Permission > Form
Breadcrumbs::register('permission-form', function ($breadcrumbs) {
    $breadcrumbs->parent('permissions');
    $breadcrumbs->push(trans('breadcrumbs.data'));
});

// Permission > Show
Breadcrumbs::register('permission-show', function ($breadcrumbs, $permission) {
    $breadcrumbs->parent('permissions');
    $breadcrumbs->push($permission->name, action('Admin\PermissionController@show', $permission->id));
});

// Organizations
Breadcrumbs::register('organizations', function ($breadcrumbs) {
    $breadcrumbs->push(trans('breadcrumbs.organizations'), action('Admin\OrganizationController@index'));
});

// Organization > Form
Breadcrumbs::register('organization-form', function ($breadcrumbs) {
    $breadcrumbs->parent('organizations');
    $breadcrumbs->push(trans('breadcrumbs.data'));
});

// Organization > Show
Breadcrumbs::register('organization-show', function ($breadcrumbs, $organization) {
    $breadcrumbs->parent('organizations');
    $breadcrumbs->push($organization->name, action('Admin\OrganizationController@show', $organization->id));
});

// Licences
Breadcrumbs::register('licences', function ($breadcrumbs) {
    $breadcrumbs->push(trans('breadcrumbs.licences'), action('Admin\LicenceController@index'));
});

// Licences > Form
Breadcrumbs::register('licence-form', function ($breadcrumbs) {
    $breadcrumbs->parent('licences');
    $breadcrumbs->push(trans('breadcrumbs.data'));
});

// Licences > Show
Breadcrumbs::register('licence-show', function ($breadcrumbs, $licence) {
    $breadcrumbs->parent('licences');
    $breadcrumbs->push($licence->name, action('Admin\LicenceController@show', $licence->id));
});
