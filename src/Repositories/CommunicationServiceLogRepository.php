<?php


namespace Mohsenbagheri\Kamui\Repositories;


use Mohsenbagheri\Kamui\Models\CommunicationServiceLog;

class CommunicationServiceLogRepository extends BaseRepository
{

    public function getFieldsSearchable(): array
    {
        return [];
    }

    public function model(): string
    {
        return CommunicationServiceLog::class;
    }
}
