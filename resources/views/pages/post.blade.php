@extends('layouts.app')
@section('title', $post ? $post->title : 'TOS')

@section('content')
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
            @if ($post)
                <div class="box">
                    <h2>{{ $post->title }}</h2>
                    {!! $post->body !!}
                </div>
            @else
                <div class="alert alert-info" role="alert">
                    <p>标识为 tos 的文章会在这里显示</p>
                </div>
            @endif
        </div>
    </div>
@stop
