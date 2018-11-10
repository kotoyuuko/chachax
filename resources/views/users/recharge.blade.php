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
                <form class="form-horizontal" method="POST" action="{{ route('payment.redeem') }}">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('code') ? ' has-error' : '' }}">
                        <label for="code" class="col-md-3 control-label">兑换码</label>

                        <div class="col-md-8">
                            <input id="code" type="text" class="form-control" name="code" required>

                            @if ($errors->has('code'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('code') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-3">
                            <button type="submit" class="btn btn-primary">
                                兑换
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="box">
                <h2>交易记录</h2>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>类型</th>
                            <th>支付方式</th>
                            <th>金额</th>
                            <th>描述</th>
                            <th>支付时间</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($logs) > 0)
                            @foreach ($logs as $log)
                                <tr>
                                    <td>#{{ $log->id }}</td>
                                    <td>
                                        @switch($log->type)
                                            @case('recharge')
                                                充值
                                                @break
                                            @case('pay')
                                                消费
                                                @break
                                            @default
                                                未知
                                        @endswitch
                                    </td>
                                    <td>
                                        @switch($log->payment)
                                            @case('balance')
                                                余额
                                                @break
                                            @case('youzan')
                                                在线支付
                                                @break
                                            @case('redeem')
                                                兑换码
                                                @break
                                            @default
                                                未知
                                        @endswitch
                                    </td>
                                    <td>{{ $log->amount }}</td>
                                    <td>{{ $log->description }}</td>
                                    <td>{{ $log->paid_at ? $log->paid_at : '未支付' }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6">没有查询到记录</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <div class="text-right">
                    {{ $logs->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
