<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="" style="background-image: url('/images/background/{{ rand(0,2) }}.jpg'); background-repeat: no-repeat; background-position: center; background-size: cover;">
    <div class="d-flex">
        @include('includes.sidebar')
        {{ $slot }}

    </div>
    @livewireScripts
</body>
</html>
