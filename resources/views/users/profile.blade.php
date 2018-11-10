@extends('layouts.app')
@section('title', '个人中心')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            @include('layouts._message')
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <div class="profile-card">
                <img class="card-avatar" src="{{ $user->avatar(512) }}">
                <div class="card-body">
                    <p><b>昵称</b><span class="pull-right">{{ $user->name }}</span></p>
                    <p><b>E-Mail</b><span class="pull-right">{{ $user->email }}</span></p>
                    <p><b>注册于</b><span class="pull-right">{{ $user->created_at->diffForHumans() }}</span></p>
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="box">
                <h2>更新资料</h2>
                <form class="form-horizontal" method="POST" action="{{ route('user.profile') }}">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label class="col-md-3 control-label">头像</label>

                        <div class="col-md-6">
                            <a class="btn btn-sm btn-info" href="https://cn.gravatar.com" target="_blank">前往 Gravatar 修改</a>
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-3 control-label">昵称</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control" name="name" value="{{ $user->name }}" required>

                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="col-md-3 control-label">E-Mail</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control" name="email" value="{{ $user->email }}" required>

                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-3">
                            <button type="submit" class="btn btn-primary">
                                更新
                            </button>
                            <span class="tip">更换 E-Mail 后需要重新验证</span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
