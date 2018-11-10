@extends('layouts.app')
@section('title', '首页')

@section('content')
    <section id="banner">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2>给你更好的网络体验</h2>
                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg">现在体验</a>
                </div>
            </div>
        </div>
    </section>
@stop
