<?php

namespace Mohsenbagheri\Kamui\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;
use Mohsenbagheri\Kamui\Models\CommunicationUpLog;
use Mohsenbagheri\Kamui\Services\CommunicationUpLogService;
use Spatie\SignalAwareCommand\SignalAwareCommand;


class CommunicateRedisWorkerCommand extends SignalAwareCommand
{

    protected $signature = 'worker:redis {keys?} {routeName?}';
    protected $description = 'Redis worker for communicate with redis service';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(CommunicationUpLogService $communicationUpLogService): int
    {
        $keys = $this->argument('keys');
        if (is_null($keys)) {
            $keys = $this->ask(__("Please type keys for subscribes by redis worker.you can type multiple key with ',' => example: test,test1,test2,..."));
            if (is_null($keys)) {
                $this->error('keys is required');
                return 0;
            }
        }

        $route = $this->argument('routeName');
        if (is_null($route)) {
            $route = $this->ask(__('Please insert route name for send response to it'));
            if (is_null($route)) {
                $this->error(__('Route name is required'));
                return 0;
            }
        }

        if (!Route::has($route)) {
            $this->error(__('Route not found'));
            return 0;
        }

        $data = Route::getRoutes()->getByName($route)->action;
        list($class, $method) = explode('@', $data['controller']);
        $controller = resolve($class);
        $keys = explode(',', $keys);

        try {
            $logMessage = sprintf('worker listen:%s', implode(',', $keys));
            $this->info($logMessage);
            $communicationUpLogService->serviceUp(CommunicationUpLog::DRIVER_REDIS, $logMessage);
            Redis::subscribe($keys, function (string $message) use ($controller, $method) {
                $message = json_decode($message);
                $controller->$method((object)$message);
            });
        } catch (\Exception $e) {
            $communicationUpLogService->serviceDown(CommunicationUpLog::DRIVER_REDIS, $e);
        }

        return 0;
    }

    public function onSigint()
    {
        $communicationUpLogService = resolve(CommunicationUpLogService::class);
        $message = "command stop by using Ctrl + C sigint";
        $communicationUpLogService->serviceDown(CommunicationUpLog::DRIVER_REDIS, $message);
        exit();
    }
}
