<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePlanRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'plan' => 'required|exists:plans,id',
        ];
    }

    public function messages()
    {
        return [
            'plan.exists' => '未找到该套餐'
        ];
    }
}
