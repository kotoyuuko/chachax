@extends('layouts.app')
@section('title', $plan->name . ' - 套餐')

@section('content')
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
            @include('layouts._message')
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
                <h2>购买</h2>
                <form class="form-horizontal" method="POST" action="{{ route('plans.confirm', $plan) }}">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('time') ? ' has-error' : '' }}">
                        <label for="time" class="col-md-3 control-label">购买时长</label>

                        <div class="col-md-6">
                            <div class="input-group">
                                <input id="time" name="time" type="number" step="1" class="form-control" aria-describedby="basic-addon" required>
                                <span class="input-group-addon" id="basic-addon">月</span>
                            </div>

                            @if ($errors->has('time'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('time') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('code') ? ' has-error' : '' }}">
                        <label for="code" class="col-md-3 control-label">优惠码</label>

                        <div class="col-md-6">
                            <input id="code" name="code" type="text" class="form-control">

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
                                购买
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
