<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class RedeemCode extends Model
{
    protected $fillable = [
        'code', 'usable', 'amount'
    ];

    public static function findAvailableCode($length = 16)
    {
        do {
            $code = Str::random($length);
        } while (self::query()->where('code', $code)->exists());

        return $code;
    }
}
