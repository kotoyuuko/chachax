@extends('layouts.app')
@section('title', '服务 #' . $service->id . ' 的流量记录')

@section('content')
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
            <div class="box">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>节点</th>
                            <th>上行流量</th>
                            <th>下行流量</th>
                            <th>记录时间</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($logs) > 0)
                            @foreach ($logs as $log)
                                <tr>
                                    <td>#{{ $log->id }}</td>
                                    <td>{{ $log->node->name }}</td>
                                    <td>{{ $log->uplink }} MiB</td>
                                    <td>{{ $log->downlink }} MiB</td>
                                    <td>{{ $log->created_at }}</td>
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
                    {{ $logs->links() }}
                </div>
            </div>
        </div>
    </div>
@stop