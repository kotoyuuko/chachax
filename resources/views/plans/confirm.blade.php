@extends('layouts.app')
@section('title', $plan->name . ' - 套餐')

@section('content')
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
            <div class="box">
                <h2>
                    <b>{{ $plan->name }}</b>
                    <small class="pull-right">
                        {{ $plan->price }} 元/月
                    </small>
                </h2>
                {!! $plan->description !!}
            </div>
            <div class="box">
                <h2>确认购买信息</h2>
                <form class="form-horizontal" method="POST" action="{{ route('plans.buy', $plan) }}">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label class="col-md-3 control-label">购买时长</label>

                        <div class="col-md-6">
                            <p>{{ $time }} 个月</p>
                        </div>
                    </div>
                    <input type="hidden" name="time" value="{{ $time }}">

                    @if ($couponCode)
                        <div class="form-group">
                            <label class="col-md-3 control-label">优惠码</label>

                            <div class="col-md-6">
                                <p>{{ $couponCode->code }}</p>
                                <span class="help-block">
                                    {{ $couponCode->description }}
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="code" class="col-md-3 control-label">原价</label>

                            <div class="col-md-6">
                                <p>{{ $plan->price }} x {{ $time }} = {{ $plan->price * $time }} 元</p>
                            </div>
                        </div>
                        <input type="hidden" name="code" value="{{ $couponCode->code }}">
                    @else
                        <input type="hidden" name="code" value="">
                    @endif

                    <div class="form-group">
                        <label class="col-md-3 control-label">支付价格</label>

                        <div class="col-md-6">
                            <p>{{ $price }} 元</p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">帐号余额</label>

                        <div class="col-md-6">
                            <p>{{ $user->balance }} 元</p>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-3">
                            <a class="btn btn-info" href="{{ route('plans.show', $plan) }}">返回修改</a>
                            @if ($user->balance - $price < 0)
                                <button type="button" class="btn btn-primary" disabled>余额不足</button>
                            @else
                                <button type="submit" class="btn btn-primary">确认购买</button>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
