@extends('layouts._notice')
@section('message.title', '错误代码 ' . $code)

@section('message.body')
    <p>{{ $message }}</p>
    <p>
        <a class="btn btn-sm btn-primary" href="javascript:history.go(-1);">返回上一页</a>
        <a class="btn btn-sm btn-info" href="{{ route('root') }}">返回首页</a>
    </p>
@endsection
