<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class CouponCode extends Model
{
    protected $fillable = [
        'code', 'type', 'value', 'total', 'used', 'not_before', 'not_after', 'enabled'
    ];

    protected $dates = ['not_before', 'not_after'];

    protected $appends = ['description'];

    public function getDescriptionAttribute()
    {
        if ($this->type === 'percent') {
            return '优惠 ' . str_replace('.00', '', $this->value) . ' %';
        }

        return '减 ' . str_replace('.00', '', $this->value);
    }

    public static function types()
    {
        return [
            'fixed' => '固定金额',
            'percent' => '比例'
        ];
    }

    public static function findAvailableCode($length = 16)
    {
        do {
            $code = Str::random($length);
        } while (self::query()->where('code', $code)->exists());

        return $code;
    }
}
