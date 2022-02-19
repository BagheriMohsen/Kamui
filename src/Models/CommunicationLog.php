<?php


namespace Mohsenbagheri\Kamui\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class CommunicationLog extends Model
{
    protected $table = 'communication_logs';

    public function setPayloadAttribute($value)
    {
        return $this->attributes['payload'] = json_decode($value);
    }

    public function getPayloadAttribute($value)
    {
        return $this->attributes['payload'] = json_encode($value);
    }

}
