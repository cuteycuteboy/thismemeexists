@extends('layout')

@section('title', 'Добавить свой шаблон')

@section('content')
    @include('partials.header')
    <div class="container">
        <form method="POST" enctype="multipart/form-data" action="{{ route("new_template") }}">
            @csrf
            <div class="p-3">
                <div class="fs-2  mb-4">Добавить свой шаблон</div>
                <input name="template" class="form-control form-control-lg mb-3" type="file" id="File">
                <button type="submit" class="btn btn-primary btn-lg">Подтвердить</button>
            </div>
        </form>
        <div class="p-3">
            @error('template')
            <p class="fs-5 text-danger">{{ $message }}</p>
            @enderror
        </div>
@endsection
