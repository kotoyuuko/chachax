@extends('layouts._notice')
@section('message.title', '请先验证 E-Mail')

@section('message.body')
    <p>本页面仅限已验证用户访问，请检查您的 E-Mail 并点击其中的验证链接完成验证。</p>
    <p>
        <a class="btn btn-sm btn-primary" href="{{ route('verification.send') }}">重新发送验证邮件</a>
        <a class="btn btn-sm btn-info" href="{{ route('root') }}">返回首页</a>
    </p>
@endsection
