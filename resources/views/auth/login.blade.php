@extends('layout')

@section('title', 'Авторизация')

@section('content')
<main class="form-signin w-100 m-auto text-center">
  <form method="POST" action="{{ route("login_process") }}">
    @csrf
    <h1 class="h3 mb-3 fw-normal">Вход</h1>

    <div class="form-floating">
        
      <input type="email" name="email" class="form-control" id="floatingInput" placeholder="Email">
      <label for="floatingInput">Email</label>
    </div>
    <div class="form-floating">
      <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Пароль">
      <label for="floatingPassword">Пароль</label>
    </div>
    @error('email')
        <p>{{ $message }}</p>
    @enderror
    @error('password')
        <p>{{ $message }}</p>
    @enderror
    <p>
        <a href="{{ route("register") }}">Регистрация</a>
    </p>
    <button class="w-100 btn btn-lg btn-primary" type="submit">Войти</button>
    <p class="mt-5 mb-3 text-muted">© 2023-2023</p>
  </form>

<style>
    html,
body {
  height: 100%;
}

body {
  display: flex;
  align-items: center;
  padding-top: 40px;
  padding-bottom: 40px;
  background-color: #f5f5f5;
}

.form-signin {
  max-width: 330px;
  padding: 15px;
}

.form-signin .form-floating:focus-within {
  z-index: 2;
}

.form-signin input[type="email"] {
  margin-bottom: -1px;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0;
}

.form-signin input[type="password"] {
  margin-bottom: 10px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}
</style>
</main>
@endsection