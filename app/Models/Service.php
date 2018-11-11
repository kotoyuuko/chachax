<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'user_id', 'plan_id', 'uuid', 'alter_id', 'security', 'traffic', 'expired_at'
    ];

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }

    public function coupon_code()
    {
        return $this->belongsTo(CouponCode::class);
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
}
