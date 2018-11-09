@extends('layouts.app')
@section('title', '提示信息')

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="box">
                @include('layouts._message')
                <h2>@yield('message.title')</h2>
                @yield('message.body')
            </div>
        </div>
    </div>
@endsection
