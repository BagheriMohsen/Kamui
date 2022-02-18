<?php

namespace Mohsenbagheri\Kamui;

use Illuminate\Support\ServiceProvider;
use Mohsenbagheri\Kamui\Commands\CommunicateRabbitmqWorkerCommand;
use Mohsenbagheri\Kamui\Commands\CommunicateRedisWorkerCommand;

class KamuiServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../migrations');

        if ($this->app->runningInConsole()) {
            $this->commands([
                CommunicateRedisWorkerCommand::class,
                CommunicateRabbitmqWorkerCommand::class
            ]);
        }

        $this->publishes([
            __DIR__.'/../config/kamui.php' => config_path('kamui.php'),
        ], 'config');

    }

    public function register()
    {

    }
}
