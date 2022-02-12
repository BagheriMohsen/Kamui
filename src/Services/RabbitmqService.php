<?php


namespace Mohsenbagheri\Kamui\Services;


class RabbitmqService extends BaseService
{

    public function driver(): string
    {
        return 'rabbitmq';
    }
}
