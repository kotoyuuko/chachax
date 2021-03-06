<?php

namespace App\Http\Controllers\Api;

use App\Models\Node;
use App\Models\Service;
use App\Models\TrafficLog;
use Illuminate\Http\Request;
use App\Http\Requests\Api\NodeClientsRequest;
use App\Transformers\NodeClientsTransformer;
use App\Notifications\TrafficExceedNotification;

class NodeClientsController extends Controller
{
    public function store(NodeClientsRequest $request)
    {
        $node = Node::findWithToken($request->token);

        if (!$node) {
            return $this->response->errorInternal('节点未注册');
        }

        \Log::info('Node sending data.', [
            'id' => $node->id
        ]);

        if ($request->clients) {
            foreach ($request->clients as $client) {
                if ($client['uplink'] + $client['uplink'] < 105) {
                    continue;
                }
                
                $service = Service::findWithUuid($client['id']);

                if (!$service) {
                    \Log::warning('Service not found', [
                        'id' => $client['id']
                    ]);

                    continue;
                }

                $traffic = ($client['uplink'] + $client['downlink']) / 1048576;
                $traffic = $traffic * $node->rate;
    
                $log = TrafficLog::create([
                    'service_id' => $service->id,
                    'node_id' => $node->id,
                    'uplink' => $client['uplink'] / 1048576,
                    'downlink' => $client['downlink'] / 1048576,
                    'traffic' => $traffic,
                ]);
    
                $service->traffic -= $traffic;
                if ($service->traffic < 0) {
                    $service->traffic = 0;
                    $service->user->notify(new TrafficExceedNotification);
                }
                $service->save();
            }
        }

        $result = collect();

        foreach ($node->plans as $plan) {
            foreach ($plan->services as $service) {
                $result->push($service);
            }
        }

        return $this->response->collection($result, new NodeClientsTransformer);
    }
}
