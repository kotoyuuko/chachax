<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class InviteCode extends Model
{
    protected $fillable = [
        'code', 'usable'
    ];

    public static function findCode($code)
    {
        return self::where('code', $code)->first();
    }

    public static function findAvailableCode($length = 16)
    {
        do {
            $code = Str::random($length);
        } while (self::query()->where('code', $code)->exists());

        return $code;
    }
}
