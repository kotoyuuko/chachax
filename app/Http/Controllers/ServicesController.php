<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Exceptions\InvalidRequestException;

class ServicesController extends Controller
{
    public function root(Request $request)
    {
        $services = $request->user()->services()->orderBy('created_at', 'desc')->paginate(15);

        return view('services.root')
            ->with('services', $services);
    }

    public function show(Request $request, Service $service)
    {
        if ($request->user()->id != $service->user_id) {
            throw new InvalidRequestException('该服务不属于已登录用户');
        }

        return view('services.show')
            ->with('user', $request->user())
            ->with('service', $service);
    }
}
