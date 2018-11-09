@extends('layouts.app')
@section('title', '提示信息')

@section('content')
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
            @include('layouts._message')
            <div class="box">
                <h2>@yield('message.title')</h2>
                @yield('message.body')
            </div>
        </div>
    </div>
@endsection
