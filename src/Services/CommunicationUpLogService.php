<?php


namespace Mohsenbagheri\Kamui\Services;


use Mohsenbagheri\Kamui\Models\CommunicationUpLog;
use Mohsenbagheri\Kamui\Repositories\CommunicationUpLogRepository;

class CommunicationUpLogService extends BaseService
{

    public function repository(): string
    {
        return CommunicationUpLogRepository::class;
    }

    public function serviceUp($driver, $payload='')
    {
        $this->repository->create([
            'driver' => $driver,
            'status' => CommunicationUpLog::STATUS_UP,
            'payload' => $payload
        ]);
    }

    public function serviceDown($driver, $payload='')
    {
        $this->repository->create([
            'driver' => $driver,
            'status' => CommunicationUpLog::STATUS_DOWN,
            'payload' => $payload
        ]);
    }
}
