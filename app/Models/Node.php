<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Node extends Model
{
    protected $fillable = [
        'name', 'description', 'address', 'port', 'network', 'settings', 'tls'
    ];

    public function plans()
    {
        return $this->belongsToMany(Plan::class, 'plan_nodes', 'node_id', 'plan_id');
    }

    public static function networks()
    {
        return [
            'tcp' => 'TCP',
            'kcp' => 'KCP',
            'ws' => 'WebSocket',
            'http' => 'HTTP',
            'domainsocket' => 'DomainSocket'
        ];
    }
}
