@extends('layout')

@section('title', 'thismemeexists')

@section('content')
@include('partials.header')
<div class="container">
    <div class="row justify-content-md-center md-5 pt-5">
    <div class="col col-md-auto"></div>
        <div class="col-12 col-md-5 col-xl-4 p-5">
            <div class="shadow-lg border border-5 border-secondary">
                <div class="img-container">
                <img src="{{ '/storage/memes/'.$meme->image_path }}" class="meme-img">
                </div>
            </div>
        </div>
        <div class="col col-md-auto"></div>
    </div>
    @include('partials.memesByThisTemplate')
</div>
<style>
    img{
        display: inline-block;
        width: 100%;
        height: auto;
    }
</style>
@endsection