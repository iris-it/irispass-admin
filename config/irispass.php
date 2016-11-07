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
