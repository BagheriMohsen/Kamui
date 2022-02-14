<?php


namespace Mohsenbagheri\Kamui\Services\Communication;


class CommunicateRestApiService extends BaseCommunicationService
{

    public function driver(): string
    {
        return 'rest';
    }
}
