<?php

namespace App\Http\Controllers;

use Uuid;
use QrCode;
use Carbon\Carbon;
use App\Models\Node;
use App\Models\Plan;
use App\Models\Service;
use App\Models\Package;
use App\Models\CouponCode;
use App\Models\PaymentLog;
use Illuminate\Http\Request;
use App\Http\Requests\ServiceSaveRequest;
use App\Http\Requests\ServiceRenewRequest;
use App\Http\Requests\PackageBuyRequest;
use App\Http\Requests\ChangePlanRequest;
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

        $packages = Package::get();
        $plans = Plan::get();

        return view('services.show')
            ->with('user', $request->user())
            ->with('service', $service)
            ->with('packages', $packages)
            ->with('plan', $plan);
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

        $payment = PaymentLog::create([
            'user_id' => $user->id,
            'type' => 'pay',
            'payment' => 'balance',
            'payment_id' => $service->id,
            'amount' => $price,
            'description' => '使用余额续费服务 #' . $service->id,
            'paid_at' => Carbon::now()
        ]);

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

    public function logs(Request $request, Service $service)
    {
        if ($request->user()->id != $service->user_id) {
            throw new InvalidRequestException('该服务不属于已登录用户');
        }

        $logs = $service->traffic_logs()->orderBy('created_at', 'desc')->paginate(15);

        return view('services.logs')
            ->with('service', $service)
            ->with('logs', $logs);
    }

    public function qrcode(Request $request, Service $service, Node $node)
    {
        if ($request->user()->id != $service->user_id) {
            throw new InvalidRequestException('该服务不属于已登录用户');
        }

        $uri = vmess_uri($service, $node);

        $qrcode = QrCode::format('png')
            ->margin(1)
            ->size(300)
            ->generate($uri);

        return response($qrcode)
            ->header('Content-Type', 'image/png');
    }

    public function reset(Request $request, Service $service)
    {
        if ($request->user()->id != $service->user_id) {
            throw new InvalidRequestException('该服务不属于已登录用户');
        }

        $service->uuid = Uuid::generate(4)->string;
        $service->save();

        $request->session()->flash('success', 'UUID 重置成功，所有节点将在 10 分钟之内同步更新。');

        return redirect()->route('services.show', $service);
    }

    public function subscription(Request $request, Service $service)
    {
        if (!$request->token) {
            throw new InvalidRequestException('访问未经授权');
        }

        if ($request->token != $service->uuid) {
            throw new InvalidRequestException('Token 不正确');
        }

        $subscriptionText = '';

        foreach ($service->plan->nodes as $node) {
            $subscriptionText .= vmess_uri($service, $node);
            $subscriptionText .= "\n";
        }

        $response = base64_encode($subscriptionText);

        return response($response)
            ->header('Content-Type', 'text/plain');
    }

    public function package(PackageBuyRequest $request, Service $service)
    {
        if ($request->user()->id != $service->user_id) {
            throw new InvalidRequestException('该服务不属于已登录用户');
        }

        $user = $request->user();
        $package = Package::find($request->package);

        if ($user->balance - $package->price < 0) {
            throw new InvalidRequestException('帐号余额不足');
        }

        $payment = PaymentLog::create([
            'user_id' => $user->id,
            'type' => 'pay',
            'payment' => 'balance',
            'payment_id' => $service->id,
            'amount' => $package->price,
            'description' => '使用余额为服务 #' . $service->id . ' 购买流量 ' . $package->traffic . ' MiB',
            'paid_at' => Carbon::now()
        ]);

        $service->traffic += $package->traffic;
        $service->save();

        $user->balance -= $package->price;
        $user->save();

        $request->session()->flash('success', '流量 ' . $package->traffic . ' MiB 购买成功');

        return redirect()->route('services.show', $service);
    }

    public function plan(ChangePlanRequest $request, Service $service)
    {
        if ($request->user()->id != $service->user_id) {
            throw new InvalidRequestException('该服务不属于已登录用户');
        }

        $plan = Plan::find($request->plan);

        $service->plan_id = $plan->id;

        $request->session()->flash('success', '服务 #' . $service->id . ' 已更换到套餐 ' . $plan->name);

        return redirect()->route('services.show', $service);
    }
}
