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

    'driver' => env('COMMUNICATE_DRIVER', 'redis')
];
