<?php


namespace Mohsenbagheri\Kamui\Services;


use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class RedisService extends BaseService
{

    public function driver(): string
    {
        return 'redis';
    }

    public function send(string $key, array $data)
    {
        try {
            Redis::publish($key, json_encode($data));
            Log::info('data successfully sent', $data);
        } catch (\Exception $e) {
            Log::error($e);
        }
    }

}
