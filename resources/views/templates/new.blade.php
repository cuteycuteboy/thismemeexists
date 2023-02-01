@extends('layout')

@section('title', 'thismemeexists')

@section('content')
    @include('partials.header')
    <form method="POST" action="{{ route("new_template") }}">
        @csrf
        <div class="container p-3">
            <div class="fs-2  mb-4">Добавить свой шаблон</div>
            <input class="form-control form-control-lg mb-3" type="file" id="formFile">
            <button type="submit" class="btn btn-primary btn-lg">Подтвердить</button>
        </div>
    </form>
@endsection
