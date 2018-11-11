<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\CouponCode;
use Illuminate\Http\Request;
use App\Http\Requests\ServiceSaveRequest;
use App\Http\Requests\ServiceRenewRequest;
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

    public function save(ServiceSaveRequest $request, Service $service)
    {
        if ($request->user()->id != $service->user_id) {
            throw new InvalidRequestException('该服务不属于已登录用户');
        }

        $service->alter_id = $request->alter_id;
        $service->security = $request->security;
        $service->save();

        $request->session()->flash('success', '连接配置已更新，所有节点将在 10 分钟之内同步设置。');

        return redirect()->route('services.show', $service);
    }

    public function renew(ServiceRenewRequest $request, Service $service)
    {
        if ($request->user()->id != $service->user_id) {
            throw new InvalidRequestException('该服务不属于已登录用户');
        }

        $couponCode = CouponCode::findCode($request->code);

        $price = $service->plan->price * $request->time;

        if ($couponCode) {
            $couponCode->checkAvailable($request->time);
            $price = $couponCode->getAdjustedPrice($price);
        }

        return view('services.renew')
            ->with('service', $service)
            ->with('couponCode', $couponCode)
            ->with('time', $request->time)
            ->with('price', $price)
            ->with('user', $request->user());
    }

    public function renewConfirm(ServiceRenewRequest $request, Service $service)
    {
        if ($request->user()->id != $service->user_id) {
            throw new InvalidRequestException('该服务不属于已登录用户');
        }

        $user = $request->user();
        $couponCode = CouponCode::findCode($request->code);

        $price = $service->plan->price * $request->time;

        if ($couponCode) {
            $couponCode->checkAvailable($request->time);
            $price = $couponCode->getAdjustedPrice($price);
        }

        if ($user->balance - $price < 0) {
            throw new InvalidRequestException('帐号余额不足');
        }

        $service->expired_at = $service->expired_at->addMonths($request->time);
        $service->save();

        $user->balance -= $price;
        $user->save();

        if ($couponCode) {
            $couponCode->used += 1;
            $couponCode->save();
        }

        $request->session()->flash('success', '服务 #' . $service->id . ' 续费成功');

        return redirect()->route('services.show', $service);
    }
}
