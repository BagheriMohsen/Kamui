<?php


namespace Mohsenbagheri\Kamui\Services\Communication;


use Illuminate\Redis\Connections\Connection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;


class CommunicateRedisService extends BaseCommunicationService
{

    public Connection $redis;
    public function __construct()
    {
        $this->redis = Redis::connection();
    }

    public function driver(): string
    {
        return 'redis';
    }

    public function send(string $key, array $data)
    {
        try {
            $this->redis->publish($key, json_encode($data));
            Log::info('data successfully sent', $data);
            return true;
        } catch (\Exception $e) {
            Log::error($e);
            return false;
        }
    }

}
