<?php


namespace Mohsenbagheri\Kamui\Repositories;


use Mohsenbagheri\Kamui\Models\CommunicationLog;

class CommunicationLogRepository extends BaseRepository
{

    public function getFieldsSearchable(): array
    {
        return [];
    }

    public function model(): string
    {
        return CommunicationLog::class;
    }
}
