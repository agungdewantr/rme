<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Page Title' }}</title>
    @vite('resources/css/app.css')
    @livewireStyles
    @vite(['resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-5.3.2-dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/toastr/css/toastr.min.css') }}">
    <link rel="icon" sizes="10x20" href="{{ asset('assets/img/logo_plus.png') }}">
    <script src="https://kit.fontawesome.com/e4b2ccaaa5.js" crossorigin="anonymous"></script>
</head>

<body
    style="background-image: url('{{ asset('assets/img/bg2.jpg') }}'); background-repat: no-repeat; background-position: center; background-size:cover; overflow:hidden"
    class="">
    <div class="">
        <img src="{{ asset('assets/img/logo_long.png') }}" alt="" style="width: 250px; position: absolute;"
            class="mt-3 ms-3 bg-white p-3 rounded">
    </div>
    {{ $slot }}
    @livewire('wire-elements-modal')
    <x-toaster-hub />
    @livewireScriptConfig
    <script src="{{ asset('assets/vendor/jquery/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap-5.3.2-dist/js/bootstrap.min.js') }}"></script>
</body>

</html>
