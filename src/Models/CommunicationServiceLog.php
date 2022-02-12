<?php


namespace Mohsenbagheri\Kamui\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class CommunicationServiceLog extends Model
{
    protected $table = 'communication_service_logs';

    protected function payload(): Attribute
    {
        return new Attribute(
            get: fn ($value) => json_encode($value),
            set: fn ($value) => json_decode($value),
        );
    }
}
