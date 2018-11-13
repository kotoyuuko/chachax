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
                        <b>总流量</b>
                        <span class="pull-right">{{ $service->plan->traffic }} MiB</span>
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
                        <a class="btn btn-sm btn-info" href="{{ route('services.logs', $service) }}">流量记录</a>
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
                            <p><img class="img-responsive" src="{{ route('services.node.qrcode', [$service, $node]) }}"></p>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="col-sm-4">
            <div class="box">
                <h4><b>续费</b></h4>
                <form class="form-horizontal" method="POST" action="{{ route('services.renew', $service) }}">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('time') ? ' has-error' : '' }}">
                        <label for="time" class="col-md-3 control-label">时长</label>

                        <div class="col-md-9">
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

                        <div class="col-md-9">
                            <input id="code" type="text" class="form-control" name="code">

                            @if ($errors->has('code'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('code') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-9 col-md-offset-3">
                            <button type="submit" class="btn btn-primary">
                                续费
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="box">
                <h4><b>设置</b></h4>
                <form class="form-horizontal" method="POST" action="{{ route('services.show', $service) }}">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('alter_id') ? ' has-error' : '' }}">
                        <label for="alter_id" class="col-md-3 control-label">Alter ID</label>

                        <div class="col-md-9">
                            <input id="alter_id" type="number" step="1" class="form-control" name="alter_id" value="{{ $service->alter_id }}" required>

                            @if ($errors->has('alter_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('alter_id') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('security') ? ' has-error' : '' }}">
                        <label for="security" class="col-md-3 control-label">加密方式</label>

                        <div class="col-md-9">
                            <select class="form-control" name="security" id="security">
                                <option value="aes-128-gcm" @if ($service->security == 'aes-128-gcm') selected @endif>AES-128-GCM</option>
                                <option value="chacha20-poly1305" @if ($service->security == 'chacha20-poly1305') selected @endif>ChaCha20-Poly1305</option>
                                <option value="auto" @if ($service->security == 'auto') selected @endif>自动</option>
                                <option value="none" @if ($service->security == 'none') selected @endif>无</option>
                            </select>

                            @if ($errors->has('security'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('security') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-9 col-md-offset-3">
                            <button type="submit" class="btn btn-primary">
                                保存
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
