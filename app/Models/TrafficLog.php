<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrafficLog extends Model
{
    protected $fillable = [
        'service_id', 'node_id', 'uplink', 'downlink'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function node()
    {
        return $this->belongsTo(Node::class, 'node_id');
    }
}
