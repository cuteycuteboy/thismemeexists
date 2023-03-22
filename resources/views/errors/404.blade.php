@extends('layout')

@section('title', 'thismemeexists')
@section('content')
    @include('partials.header')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col col-9 col-md-6 col-lg-5">
                <div class="mb-3">
                    <img src="{{ Vite::asset('resources/images/404cat.png') }}">
                </div>
                @if (isset($exception))
                <div class="text-center fs-2">{{ $exception->getMessage() }}</div>
                @endif
                <a href="{{ route('home') }}">
                    <div class="text-center fs-3">На главную</div>
                </a>
            </div>
        </div>
    </div>
<style>
    img{
        display: inline-block;
        width: 100%;
        height: auto;
    }
</style>
@endsection