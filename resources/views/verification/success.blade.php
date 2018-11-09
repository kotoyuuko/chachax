@extends('layouts._notice')
@section('message.title', 'E-Mail 验证成功')

@section('message.body')
    <p>恭喜，E-Mail 已经成功验证。</p>
    <p>
        <a class="btn btn-sm btn-info" href="{{ route('root') }}">返回首页</a>
    </p>
@endsection
