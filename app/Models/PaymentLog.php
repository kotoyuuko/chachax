<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentLog extends Model
{
    protected $fillable = [
        'user_id', 'type', 'payment', 'payment_id', 'amount', 'description', 'paid_at'
    ];
}
