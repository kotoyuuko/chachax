<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . Auth::id()
        ];
    }

    public function messages()
    {
        return [
            'email.unique' => 'E-Mail 已被占用'
        ];
    }
}
