<?php

namespace App\Transformers;

use App\Models\Service;
use League\Fractal\TransformerAbstract;

class NodeClientsTransformer extends TransformerAbstract
{
    public function transform(Service $service)
    {
        return [
            'id' => $service->uuid,
            'email' => $service->id . '_' . $service->user->email,
            'alterId' => $service->alter_id,
            'security' => $service->security,
            'level' => $service->plan->level,
        ];
    }
}
