<?php

namespace App\Http\Controllers;

use Uuid;
use Carbon\Carbon;
use App\Models\Plan;
use App\Models\Service;
use App\Models\CouponCode;
use Illuminate\Http\Request;
use App\Http\Requests\BuyRequest;
use App\Exceptions\InvalidRequestException;

class PlansController extends Controller
{
    public function root()
    {
        $plans = Plan::where('stock', '>', 0)->paginate(10);

        return view('plans.root')
            ->with('plans', $plans);
    }

    public function show(Plan $plan)
    {
        if ($plan->stock < 1) {
            throw new InvalidRequestException('该套餐库存不足');
        }

        return view('plans.show')
            ->with('plan', $plan);
    }

    public function confirm(BuyRequest $request, Plan $plan)
    {
        if ($plan->stock < 1) {
            throw new InvalidRequestException('该套餐库存不足');
        }

        $couponCode = CouponCode::findCode($request->code);

        $price = $plan->price * $request->time;

        if ($couponCode) {
            $couponCode->checkAvailable($request->time);
            $price = $couponCode->getAdjustedPrice($price);
        }

        return view('plans.confirm')
            ->with('plan', $plan)
            ->with('couponCode', $couponCode)
            ->with('time', $request->time)
            ->with('price', $price)
            ->with('user', $request->user());
    }

    public function buy(BuyRequest $request, Plan $plan)
    {
        if ($plan->stock < 1) {
            throw new InvalidRequestException('该套餐库存不足');
        }

        $user = $request->user();
        $couponCode = CouponCode::findCode($request->code);

        $price = $plan->price * $request->time;

        if ($couponCode) {
            $couponCode->checkAvailable($request->time);
            $price = $couponCode->getAdjustedPrice($price);
        }

        if ($user->balance - $price < 0) {
            throw new InvalidRequestException('帐号余额不足');
        }

        $service = Service::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'uuid' => Uuid::generate(4)->string,
            'alter_id' => config('env.default_alter_id'),
            'security' => config('env.default_security'),
            'traffic' => $plan->traffic,
            'expired_at' => Carbon::now()->addMonths($request->time)
        ]);

        $plan->stock -= 1;
        $plan->save();

        $user->balance -= $price;
        $user->save();

        if ($couponCode) {
            $couponCode->used += 1;
            $couponCode->save();
        }

        $request->session()->flash('success', '套餐 ' . $plan->name . ' 购买成功');

        return redirect()->route('services.show', $service);
    }
}
