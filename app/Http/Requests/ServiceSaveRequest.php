<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceSaveRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'alter_id' => 'required|numeric|min:2|max:32',
            'security' => 'required|string|in:aes-128-gcm,chacha20-poly1305,auto,none'
        ];
    }

    public function messages()
    {
        return [
            'alter_id.min' => 'Alter ID 必须为 2 到 32 的整数',
            'alter_id.max' => 'Alter ID 必须为 2 到 32 的整数',
            'security.in' => '加密方式不合法'
        ];
    }
}
