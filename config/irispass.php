<?php


return [


    /*
    |--------------------------------------------------------------------------
    | File open on external domains
    |--------------------------------------------------------------------------
    | Set the lifetime of the access token
    | If expired no one can retrieve this link
    |
    */
    'file_token_lifetime' => 60,

    /*
    |--------------------------------------------------------------------------
    | Service Configuration
    |--------------------------------------------------------------------------
    |
    | Because JWT auth read the sub in the jwt and it's not
    | the id column but the sub column so..
    | 'osjs' => [
    |    'driver' => 'local',
    |    'root'   => env('OSJS_VFS_PATH'),
    |  ],
    |
    */

    'cms' => [
    'master_path' => env('CMS_MASTER_PATH'),
    'path' => env('CMS_PATH'),
],

    'osjs' => [
    'disk' => env('OSJS_DISK'),
    'vfs_path' => env('OSJS_VFS_PATH')
],

    /*
    |--------------------------------------------------------------------------
    | Keycloak Configuration
    |--------------------------------------------------------------------------
    |
    | Because JWT auth read the sub in the jwt and it's not
    | the id column but the sub column so..
    | 'osjs' => [
    |    'driver' => 'local',
    |    'root'   => env('OSJS_VFS_PATH'),
    |  ],
    |
    */

    'keycloak' => [
    'username' => env('KEYCLOAK_USERNAME'),
    'password' => env('KEYCLOAK_PASSWORD'),
],

];
