<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Page Title' }}</title>
    @vite('resources/css/app.css')
    @livewireStyles
    <script src="{{ asset('assets/vendor/jquery/jquery-3.7.1.min.js') }}"></script>
    @vite(['resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-5.3.2-dist/css/bootstrap.min.css') }}">
    <link rel="icon" sizes="10x20" href="{{ asset('assets/img/logo_plus.png') }}">
    <script src="https://kit.fontawesome.com/e4b2ccaaa5.js" crossorigin="anonymous"></script>
</head>

<body class="tw-bg-[#F1F3F6]">
    {{ $slot }}
    @livewire('wire-elements-modal')
    <x-toaster-hub />
    @livewireScriptConfig
    <script data-navigate-once src="{{ asset('assets/vendor/bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('vendor/livewire-alert/livewire-alert.js') }}"></script>
    <x-livewire-alert::scripts />
    <x-livewire-alert::flash />

</body>

</html>
