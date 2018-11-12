<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'user_id', 'plan_id', 'uuid', 'alter_id', 'security', 'traffic', 'expired_at'
    ];

    protected $dates = ['expired_at'];

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }

    public function traffic_logs()
    {
        return $this->hasMany(TrafficLog::class, 'service_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function securities()
    {
        return [
            'aes-128-gcm' => 'AES-128-GCM',
            'chacha20-poly1305' => 'ChaCha20-Poly1305',
            'auto' => '自动',
            'none' => '无'
        ];
    }

    public static function findWithUuid($uuid)
    {
        return self::where('uuid', $uuid)->first();
    }
}
