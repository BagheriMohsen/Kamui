<?php

namespace Mohsenbagheri\Kamui\Commands;

use Illuminate\Console\Command;

class CommunicateRabbitmqWorkerCommand extends Command
{

    protected $signature = 'worker:rabbitmq';
    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        return 0;
    }
}
