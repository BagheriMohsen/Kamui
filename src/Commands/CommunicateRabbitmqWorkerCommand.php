<?php

namespace Mohsenbagheri\Kamui\Commands;

use Illuminate\Support\Facades\Route;
use Mohsenbagheri\Kamui\Models\CommunicationUpLog;
use Mohsenbagheri\Kamui\Services\CommunicationUpLogService;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Spatie\SignalAwareCommand\SignalAwareCommand;

class CommunicateRabbitmqWorkerCommand extends SignalAwareCommand
{

    protected $signature = 'worker:rabbitmq {keys?} {routeName?}';
    protected $description = 'Command description';

    private $connection;
    private $channel;

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(CommunicationUpLogService $communicationUpLogService)
    {
        $this->connection();

        $keys = $this->argument('keys');
        if (is_null($keys)) {
            $keys = $this->ask(__("Please type keys for subscribes by redis worker.you can type multiple key with ',' => example: test,test1,test2,..."));
            if (is_null($keys)) {
                $this->error('keys is required');
                return 0;
            }
        }

        $route = $this->argument('routeName');
        if (is_null($route)) {
            $route = $this->ask(__('Please insert route name for send response to it'));
            if (is_null($route)) {
                $this->error(__('Route name is required'));
                return 0;
            }
        }

        if (!Route::has($route)) {
            $this->error(__('Route not found'));
            return 0;
        }

        $data = Route::getRoutes()->getByName($route)->action;
        list($class, $method) = explode('@', $data['controller']);
        $controller = resolve($class);

        $callback = function ($req) use($controller, $method) {
            $body = intval($req->body);
            $msg = new AMQPMessage(
                (string) $controller->$method($body),
                array('correlation_id' => $req->get('correlation_id'))
            );

            $req->delivery_info['channel']->basic_publish(
                $msg,
                '',
                $req->get('reply_to')
            );
            $req->ack();
        };

        $this->channel->basic_qos(null, 1, null);
        $this->channel->basic_consume('rpc_queue', '', false, false, false, false, $callback);

        try {
            $logMessage = sprintf('worker listen:%s', $keys);
            $this->info($logMessage);
            $communicationUpLogService->serviceUp(CommunicationUpLog::DRIVER_RABBITMQ, $logMessage);
            while ($this->channel->is_open()) {
                $this->channel->wait();
            }
        } catch (\Exception $e) {
            $communicationUpLogService->serviceDown(CommunicationUpLog::DRIVER_RABBITMQ, $e);
            $this->channel->close();
            $this->connection->close();
        }

        return 0;
    }

    public function connection()
    {
        $this->connection = new AMQPStreamConnection(
            config('kamui.connections.rabbitmq.host'),
            config('kamui.connections.rabbitmq.port'),
            config('kamui.connections.rabbitmq.user'),
            config('kamui.connections.rabbitmq.password'),
            config('kamui.connections.rabbitmq.vhost')
        );
        $this->channel = $this->connection->channel();
        $this->channel->queue_declare('rpc_queue', false, false, false, false);
    }

    public function onSigint()
    {
        $communicationUpLogService = resolve(CommunicationUpLogService::class);
        $message = "command stop by using Ctrl + C sigint";
        $communicationUpLogService->serviceDown(CommunicationUpLog::DRIVER_RABBITMQ, $message);
        exit();
    }

}
