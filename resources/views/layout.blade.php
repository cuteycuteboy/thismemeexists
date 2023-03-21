<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>
    <link rel="icon" type="image/x-icon" href="{{ Vite::asset('resources/img/favicon.svg') }}">
    @vite(['resources/js/app.js', 'resources/css/app.scss'])
</head>
<body>
    @yield('content')
</body>
</html>