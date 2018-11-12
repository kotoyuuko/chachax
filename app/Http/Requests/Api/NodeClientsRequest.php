<?php

namespace App\Http\Requests\Api;

use Rap2hpoutre\UuidRule\UuidRule;
use Dingo\Api\Http\FormRequest;

class NodeClientsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'token' => 'required|string|exists:nodes,token',
            'clients' => 'required|array',
            'clients.*.uuid' => ['required', new UuidRule],
            'clients.*.uplink' => 'required|numeric',
            'clients.*.downlink' => 'required|numeric',
        ];
    }
}
