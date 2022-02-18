<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Communicate Driver
    |--------------------------------------------------------------------------
    |
    | Here you may configure the communicate driver for your application
    |
    | Available Drivers: "redis", "rabbitmq", "rest", "grpc",
    |
    */
    'driver' => env('COMMUNICATE_DRIVER', 'redis'),

    'connections' => [

        /*
        |--------------------------------------------------------------------------
        | Redis
        |--------------------------------------------------------------------------
        |*/
        'redis' => [
            'client' => env('REDIS_CLIENT', 'phpredis'),
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_DB', '0'),
        ],

        /*
        |--------------------------------------------------------------------------
        | Rabbitmq
        |--------------------------------------------------------------------------
        |*/
        'rabbitmq' => [
            'host' => env('RABBITMQ_HOST', '127.0.0.1'),
            'port' => env('RABBITMQ_PORT', 5672),
            'user' => env('RABBITMQ_USER', 'guest'),
            'password' => env('RABBITMQ_PASSWORD', 'guest'),
            'vhost' => env('RABBITMQ_VHOST', '/'),
        ],
    ]

];
