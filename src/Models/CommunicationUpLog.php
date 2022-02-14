<?php


namespace Mohsenbagheri\Kamui\Models;


use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class CommunicationUpLog extends Model
{
    public $table = 'communication_up_logs';
    public $timestamps = false;

    protected function payload(): Attribute
    {
        return new Attribute(
            get: fn ($value) => json_encode($value),
            set: fn ($value) => json_decode($value),
        );
    }
}
