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