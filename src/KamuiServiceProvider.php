<?php

namespace Mohsenbagheri\Kamui;

use Illuminate\Support\ServiceProvider;
use Mohsenbagheri\Kamui\Contracts\CommunicateServiceContract;
use Mohsenbagheri\Kamui\Services\GrpcService;
use Mohsenbagheri\Kamui\Services\RabbitmqService;
use Mohsenbagheri\Kamui\Services\RedisService;
use Mohsenbagheri\Kamui\Services\RestApiService;

class KamuiServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/migrations');

        $this->publishes([
            __DIR__.'/config/config.php' => config_path('kamui.php'),
        ]);

        $this->app->bind(CommunicateServiceContract::class, function () {
            $driver = config('kamui.driver');
            return match ($driver) {
                'redis' => new RedisService(),
                'rest' => new RestApiService(),
                'grpc' => new GrpcService(),
                'rabbitmq' => new RabbitmqService()
            };
        });
    }

    public function register()
    {

    }
}
