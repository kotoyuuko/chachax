<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PackageBuyRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'package' => 'required|exists:packages,id',
        ];
    }

    public function messages()
    {
        return [
            'package.exists' => '未找到该流量包'
        ];
    }
}
