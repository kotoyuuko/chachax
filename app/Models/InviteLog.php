<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InviteLog extends Model
{
    protected $fillable = [
        'invite_code_id', 'user_id'
    ];
}
