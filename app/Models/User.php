<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'verified_at'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function avatar(int $size)
    {
        return 'https://gravatar.loli.net/avatar/' . md5($this->email) . '?s=' . $size;
    }

    public function payment_logs()
    {
        return $this->hasMany(PaymentLog::class, 'user_id');
    }
}
