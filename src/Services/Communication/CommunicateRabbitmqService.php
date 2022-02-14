<?php


namespace Mohsenbagheri\Kamui\Services\Communication;


class CommunicateRabbitmqService extends BaseCommunicationService
{

    public function driver(): string
    {
        return 'rabbitmq';
    }
}
