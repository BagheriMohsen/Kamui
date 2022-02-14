<?php


namespace Mohsenbagheri\Kamui\Services;


use Mohsenbagheri\Kamui\Repositories\CommunicationLogRepository;

class CommunicationLogService extends BaseService
{

    public function repository(): string
    {
        return CommunicationLogRepository::class;
    }
}
