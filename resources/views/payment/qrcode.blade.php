@extends('layouts.app')
@section('title', '在线充值')

@section('content')
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
            <div class="box">
                <div class="alert alert-info" role="alert">
                    <p>请扫描下面的二维码继续支付，二维码 30 分钟内有效，请尽快支付！</p>
                    <p>支付成功后余额将在一分钟内自动更新，如未到账请联系管理员。</p>
                </div>
                <p class="text-center">
                    <img class="img-responsive center-block" src="{{ $qrcode }}">
                </p>
                <p class="text-center">
                    <a class="btn btn-sm btn-primary" href="{{ route('user.recharge') }}">返回</a>
                </p>
            </div>
        </div>
    </div>
@endsection
