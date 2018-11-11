@extends('layouts.app')
@section('title', '套餐')

@section('content')
    <div class="row">
        @if (count($plans) > 0)
            @foreach ($plans as $plan)
                <div class="col-sm-6">
                    <div class="box">
                        <h2>
                            <b>{{ $plan->name }}</b>
                            <small class="pull-right">
                                {{ $plan->price }} 元/月
                            </small>
                        </h2>
                        {!! $plan->description !!}
                        <p class="text-right">
                            <a class="btn btn-primary" href="{{ route('plans.show', $plan) }}">购买</a>
                        </p>
                    </div>
                </div>
            @endforeach
        @else
            <div class="alert alert-info" role="alert">
                <p>目前没有可用套餐</p>
            </div>
        @endif
    </div>
@stop
