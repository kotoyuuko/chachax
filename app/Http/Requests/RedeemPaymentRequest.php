<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class RedeemPaymentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'code' => [
                'required',
                'string',
                Rule::exists('redeem_codes')->where(function ($query) {
                    $query->where('usable', '>', 0);
                }),
            ]
        ];
    }

    public function messages()
    {
        return [
            'code.exists' => '兑换码无效或已过期'
        ];
    }
}
