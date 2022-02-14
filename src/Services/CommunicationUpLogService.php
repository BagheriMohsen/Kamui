<?php


namespace Mohsenbagheri\Kamui\Services;


use Mohsenbagheri\Kamui\Repositories\CommunicationUpLogRepository;

class CommunicationUpLogService extends BaseService
{

    public function repository(): string
    {
        return CommunicationUpLogRepository::class;
    }
}
