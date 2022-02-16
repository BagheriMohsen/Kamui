<?php


namespace Mohsenbagheri\Kamui\Models;


use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class CommunicationUpLog extends Model
{
    public $table = 'communication_up_logs';
    public $timestamps = false;

    protected $fillable = ['driver', 'status', 'payload', 'date'];

    const STATUS_UP = 'UP';
    const STATUS_DOWN = 'DOWN';

    const DRIVER_REDIS = 'REDIS';
    const DRIVER_RABBITMQ = 'RABBITMQ';
}
