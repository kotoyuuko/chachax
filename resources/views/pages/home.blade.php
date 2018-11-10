@extends('layouts.app')
@section('title', '首页')

@section('content')
    <div class="row">
        @if (count($posts) > 0)
            @foreach ($posts as $post)
                <div class="col-sm-6">
                    <div class="box">
                        <h2>{{ $post->title }}</h2>
                        {{ $post->body }}
                    </div>
                </div>
            @endforeach
        @else
            <div class="alert alert-info" role="alert">
                <p>这里似乎没有公告</p>
            </div>
        @endif
    </div>
@stop
