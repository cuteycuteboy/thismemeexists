@extends('layout')

@section('title', 'Регистрация')

@section('content')
    <div>
        <div>
            <h1>Регистрация</h1>

            <form action="{{ route("register_process") }}" method="POST">
                @csrf

                <input name="name" type="text" placeholder="Имя" />
                @error('name')
                <p>{{ $message }}</p>
                @enderror

                <input name="email" type="text" placeholder="Email" />
                @error('email')
                    <p>{{ $message }}</p>
                @enderror

                <input name="password" type="password" placeholder="Пароль" />
                @error('password')
                    <p>{{ $message }}</p>
                @enderror

                <input name="password_confirmation" type="password" placeholder="Подтверждение пароля" />
                @error('password_confirmation')
                    <p>{{ $message }}</p>
                @enderror


                <div>
                    <a href="{{ route("login") }}" >Есть аккаунт?</a>
                </div>

                <button type="submit">Зарегистрироваться</button>
            </form>
        </div>
    </div>
@endsection