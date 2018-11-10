@extends('layouts.app')
@section('title', '充值')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            @include('layouts._message')
            <div class="alert alert-info" role="alert">
                <strong>帐号余额</strong>
                {{ $user->balance }} 元
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <div class="box">
                <h2>在线充值</h2>
                <form class="form-horizontal" method="POST" action="{{ route('payment.online') }}">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                        <label for="amount" class="col-md-3 control-label">金额</label>

                        <div class="col-md-8">
                            <input id="amount" type="number" step="0.01" class="form-control" name="amount" required>

                            @if ($errors->has('amount'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('amount') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-3">
                            <button type="submit" class="btn btn-primary">
                                充值
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="box">
                <h2>兑换码</h2>
                <p>test</p>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="box">
                <h2>交易记录</h2>
            </div>
        </div>
    </div>
@endsection
