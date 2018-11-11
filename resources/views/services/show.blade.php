@extends('layouts.app')
@section('title', '服务 #' . $service->id)

@section('content')
    <div class="row">
        <div class="col-sm-12">
            @include('layouts._message')
        </div>
    </div>
    <div class="row">
        <div class="col-sm-8">
            <div class="col-sm-12">
                <div class="box">
                    <h4>
                        <b>服务 #{{ $service->id }}</b>
                        <span class="pull-right">{{ $service->plan->name }}</span>
                    </h4>
                    <p>
                        <b>UUID</b>
                        <span class="pull-right">{{ $service->uuid }}</span>
                    </p>
                    <p>
                        <b>Alter ID</b>
                        <span class="pull-right">{{ $service->alter_id }}</span>
                    </p>
                    <p>
                        <b>Level</b>
                        <span class="pull-right">{{ $service->plan->level }}</span>
                    </p>
                    <p>
                        <b>加密方式</b>
                        <span class="pull-right">{{ App\Models\Service::securities()[$service->security] }}</span>
                    </p>
                    <p>
                        <b>可用流量</b>
                        <span class="pull-right">{{ $service->traffic }} MiB</span>
                    </p>
                    <p>
                        <b>过期时间</b>
                        <span class="pull-right">{{ $service->expired_at }}</span>
                    </p>
                    <p class="text-right">
                        <a class="btn btn-sm btn-info" href="">流量记录</a>
                    </p>
                </div>
            </div>
            @if (count($service->plan->nodes) > 0)
                @foreach ($service->plan->nodes as $node)
                    <div class="col-sm-6">
                        <div class="box">
                            <h4>
                                <b>节点 #{{ $node->id }}</b>
                                <span class="pull-right">{{ $node->name }}</span>
                            </h4>
                            <p>
                                <b>连接地址</b>
                                <span class="pull-right">{{ $node->address }}</span>
                            </p>
                            <p>
                                <b>端口</b>
                                <span class="pull-right">{{ $node->port }}</span>
                            </p>
                            <p>
                                <b>协议</b>
                                <span class="pull-right">{{ App\Models\Node::networks()[$node->network] }}</span>
                            </p>
                            <p>
                                <b>连接配置</b>
                                <span class="pull-right">{{ $node->settings }}</span>
                            </p>
                            <p>
                                <b>TLS</b>
                                <span class="pull-right">{{ $node->tls ? '开' : '关' }}</span>
                            </p>
                            <p>{{ $node->description }}</p>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="col-sm-4">
            <div class="box">
                <h4><b>续费</b></h4>
                <p>test</p>
            </div>
            <div class="box">
                <h4><b>设置</b></h4>
                <p>test</p>
            </div>
        </div>
    </div>
@endsection
