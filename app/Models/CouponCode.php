<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use App\Exceptions\CouponCodeUnavailableException;

class CouponCode extends Model
{
    protected $fillable = [
        'code', 'type', 'value', 'limit', 'total', 'used', 'not_before', 'not_after', 'enabled'
    ];

    protected $dates = ['not_before', 'not_after'];

    protected $appends = ['description'];

    public function getDescriptionAttribute()
    {
        if ($this->type === 'percent') {
            return '优惠 ' . str_replace('.00', '', $this->value) . ' %';
        }

        return '减 ' . str_replace('.00', '', $this->value) . ' 元';
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

    public static function findCode($code)
    {
        $now = Carbon::now();

        return self::where('code', $code)
            ->where('enabled', true)
            ->first();
    }

    public function checkAvailable($time)
    {
        if (!$this->enabled) {
            throw new CouponCodeUnavailableException('优惠券不可用');
        }

        if ($this->total - $this->used <= 0) {
            throw new CouponCodeUnavailableException('该优惠券已被兑完');
        }

        if ($this->not_before && $this->not_before->gt(Carbon::now())) {
            throw new CouponCodeUnavailableException('该优惠券现在还不能使用');
        }

        if ($this->not_after && $this->not_after->lt(Carbon::now())) {
            throw new CouponCodeUnavailableException('该优惠券已过期');
        }

        if ($time < $this->limit) {
            throw new CouponCodeUnavailableException('购买时间未达到优惠码使用条件');
        }
    }

    public function getAdjustedPrice($origin)
    {
        if ($this->type === 'fixed') {
            return max(0.01, $origin - $this->value);
        }

        return number_format($origin * (100 - $this->value) / 100, 2, '.', '');
    }
}
