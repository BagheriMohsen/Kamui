<?php


namespace Mohsenbagheri\Kamui\Services;


use Mohsenbagheri\Kamui\Repositories\CommunicationServiceLogRepository;

class RedisService extends BaseService
{

    public function driver(): string
    {
        return 'redis';
    }
}
