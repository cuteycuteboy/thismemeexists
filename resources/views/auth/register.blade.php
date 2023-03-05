@extends('layout')

@section('title', 'Регистрация')

@section('content')
<main class="form-signin w-100 m-auto text-center">
    <form action="{{ route("register_process") }}" method="POST">
    @csrf
    <h1 class="h3 mb-3 fw-normal">Регистрация</h1>

    <div class="form-floating">
      <input type="text" name="name" class="form-control" id="floatingName" placeholder="Имя">
      <label for="floatingName">Имя</label>
    </div>
    <div class="form-floating">
      <input type="email" name="email" class="form-control" id="floatingInput" placeholder="Email">
      <label for="floatingInput">Email</label>
    </div>
    <div class="form-floating">
      <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Пароль">
      <label for="floatingPassword">Пароль</label>
    </div>
    <div class="form-floating">
      <input type="password" name="password_confirmation" class="form-control" id="floatingPasswordConf" placeholder="Подтверждение пароля">
      <label for="floatingPasswordConf">Подтверждение пароля</label>
    </div>
    @error('email')
        <p>{{ $message }}</p>
    @enderror
    @error('password')
        <p>{{ $message }}</p>
    @enderror
    <button class="w-100 mt-4 btn btn-lg btn-primary" type="submit">Зарегистрироваться</button>
    <p class="mt-2">
        <a href="{{ route("login") }}" >Есть аккаунт?</a>
    </p>
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

</style>
</main>
@endsection