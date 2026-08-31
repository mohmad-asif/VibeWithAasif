<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Session Driver
    |--------------------------------------------------------------------------
    |
    | Supported: "file", "cookie", "database", "memcached",
    |            "redis", "dynamodb", "array"
    |
    */

    'driver' => env('SESSION_DRIVER') ?: 'database',

    /*
    |--------------------------------------------------------------------------
    | Session Lifetime
    |--------------------------------------------------------------------------
    */

    'lifetime' => (int) env('SESSION_LIFETIME', 120),

    'expire_on_close' => env('SESSION_EXPIRE_ON_CLOSE', false),

    /*
    |--------------------------------------------------------------------------
    | Session Encryption
    |--------------------------------------------------------------------------
    */

    'encrypt' => env('SESSION_ENCRYPT', false),

    /*
    |--------------------------------------------------------------------------
    | Session File Location
    |--------------------------------------------------------------------------
    */

    'files' => storage_path('framework/sessions'),

    /*
    |--------------------------------------------------------------------------
    | Session Database Connection
    |--------------------------------------------------------------------------
    */

    'connection' => env('SESSION_CONNECTION'),

    'table' => env('SESSION_TABLE', 'sessions'),

    'store' => env('SESSION_STORE'),

    'lottery' => [2, 100],

    /*
    |--------------------------------------------------------------------------
    | Session Cookie Settings
    |--------------------------------------------------------------------------
    */

    'cookie' => env('SESSION_COOKIE', 'vibe_session'),

    'path' => env('SESSION_PATH', '/'),

    'domain' => env('SESSION_DOMAIN', null),

    'secure' => true,

    'http_only' => true,

    'same_site' => 'lax',

    'partitioned' => false,

];
