@extends('layouts.app')
@section('title', '服务')

@section('content')
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
            <div class="box">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>套餐</th>
                            <th>可用流量</th>
                            <th>过期时间</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($services) > 0)
                            @foreach ($services as $service)
                                <tr>
                                    <td>#{{ $service->id }}</td>
                                    <td>{{ $service->plan->name }}</td>
                                    <td>{{ $service->traffic }} MiB</td>
                                    <td>{{ $service->expired_at }}</td>
                                    <td>
                                        <a class="btn btn-xs btn-primary" href="{{ route('services.show', $service) }}">详情</a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5">没有查询到记录</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <div class="text-center">
                    {{ $services->links() }}
                </div>
            </div>
        </div>
    </div>
@stop
