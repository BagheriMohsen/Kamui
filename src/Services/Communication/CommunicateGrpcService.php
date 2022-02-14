<?php


namespace Mohsenbagheri\Kamui\Services\Communication;


class CommunicateGrpcService extends BaseCommunicationService
{

    public function driver(): string
    {
        return 'grpc';
    }
}
