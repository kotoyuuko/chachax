<?php

namespace App\Models;

use Illuminate\Support\Str;
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

    public static function findWithToken($token)
    {
        return self::where('token', $token)->first();
    }

    public static function findAvailableToken($length = 32)
    {
        do {
            $token = Str::random($length);
        } while (self::query()->where('token', $token)->exists());

        return $token;
    }
}
