<?php


namespace Mohsenbagheri\Kamui\Repositories;


use Mohsenbagheri\Kamui\Models\CommunicationUpLog;

class CommunicationUpLogRepository extends BaseRepository
{

    public function getFieldsSearchable(): array
    {
        return [];
    }

    public function model(): string
    {
        return CommunicationUpLog::class;
    }
}
