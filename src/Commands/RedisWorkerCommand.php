<?php

namespace Mohsenbagheri\Kamui\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;
use Mohsenbagheri\Kamui\Services\RedisService;


class RedisWorkerCommand extends Command
{

    protected $signature = 'worker:redis {keys?} {routeName?}';
    protected $description = 'Redis worker for communicate with redis service';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $keys = $this->argument('keys');
        if(is_null($keys)) {
            $keys = $this->ask("Please type keys for subscribes by redis worker.you can type multiple key with ',' => example: test,test1,test2,...");
            if(is_null($keys)) {
                $this->error('keys is required');
                return 0;
            }
        }

        $route = $this->argument('routeName');
        if(is_null($route)) {
            $route = $this->ask("Please insert route name for send response to it");
            if(is_null($route)) {
                $this->error('route name is required');
                return 0;
            }
        }

        if(!Route::has($route)) {
            $this->error('Route not found');
            return 0;
        }

        $data = Route::getRoutes()->getByName('test')->action;
        list($class, $method) = explode('@', $data['controller']);
        $controller = resolve($class);
        $keys = explode(',', $keys);

        try {
            $this->info(sprintf('redis worker listen:%s', implode(',', $keys)));
            Redis::subscribe($keys, function (string $message) use($controller, $method) {
                $message = json_decode($message);
                $controller->$method((object)$message);
            });
        } catch (\Exception $e) {
            Log::error($e);
        }

        return 0;
    }
}
