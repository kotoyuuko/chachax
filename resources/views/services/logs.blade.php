@extends('layouts.app')
@section('title', '服务 #' . $service->id . ' 的流量记录')

@section('content')
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
            <div class="alert alert-info" role="alert">
                <strong>结算流量计算公式</strong>
                结算流量 = (上行流量 + 下行流量) * 节点费率
            </div>
            <div class="box table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>节点</th>
                            <th>费率</th>
                            <th>上行流量</th>
                            <th>下行流量</th>
                            <th>结算流量</th>
                            <th>记录时间</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($logs) > 0)
                            @foreach ($logs as $log)
                                <tr>
                                    <td>#{{ $log->id }}</td>
                                    <td>{{ $log->node->name }}</td>
                                    <td>{{ $log->node->rate }}x</td>
                                    <td>{{ $log->uplink }} MiB</td>
                                    <td>{{ $log->downlink }} MiB</td>
                                    <td>{{ $log->traffic }} MiB</td>
                                    <td>{{ $log->created_at }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7">没有查询到记录</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="text-center">
                {{ $logs->links() }}
            </div>
        </div>
    </div>
@stop
