<!doctype html>
<html class="no-js" lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title> Bermakna Mulia </title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- <link rel="manifest" href="site.webmanifest"> --}}
    <link rel="icon" sizes="10x20" href="{{ asset('assets/img/logo_plus.png') }}">

    <script src="{{ asset('assets/vendor/jquery/jquery-3.7.1.min.js') }}"></script>
	<!-- CSS here -->
    @livewireStyles
    @vite(['resources/js/app.js'])
    <style>
        .nice-select.form-control.select2, .nice-select.form-control{
            display: none;
        }
        #blood_type {
            height: 55px !important;
            width: 100% !important;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-5.3.2-dist/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{asset('assets/assets/css/owl.carousel.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/assets/css/slicknav.css')}}">
    <link rel="stylesheet" href="{{asset('assets/assets/css/flaticon.css')}}">
    <link rel="stylesheet" href="{{asset('assets/assets/css/gijgo.css')}}">
    <link rel="stylesheet" href="{{asset('assets/assets/css/animate.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/assets/css/animated-headline.css')}}">
	<link rel="stylesheet" href="{{asset('assets/assets/css/magnific-popup.css')}}">
	<link rel="stylesheet" href="{{asset('assets/assets/css/fontawesome-all.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/assets/css/themify-icons.css')}}">
	<link rel="stylesheet" href="{{asset('assets/assets/css/slick.css')}}">
	<link rel="stylesheet" href="{{asset('assets/assets/css/nice-select.css')}}">
	<link rel="stylesheet" href="{{asset('assets/assets/css/style.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/flatpickr/css/flatpickr.min.css') }}">
    <script src="{{ asset('assets/vendor/flatpickr/js/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/vendor/flatpickr/js/id.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2-bootstrap-5-theme.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}">
    <script src="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>



</head>
<body>
    {{ $slot }}
    @livewireScriptConfig
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('vendor/livewire-alert/livewire-alert.js') }}"></script>
    <x-livewire-alert::scripts />
    <x-livewire-alert::flash />

    <script  src="{{asset('assets/assets/js/vendor/modernizr-3.5.0.min.js')}}"></script>
    <!-- Jquery, Popper, Bootstrap -->
    <script  src="{{asset('assets/assets/js/popper.min.js')}}"></script>
    <script  src="{{asset('assets/assets/js/bootstrap.min.js')}}"></script>
    <!-- Jquery Mobile Menu -->
    <script  src="{{asset('assets/assets/js/jquery.slicknav.min.js')}}"></script>

    <!-- Jquery Slick , Owl-Carousel Plugins -->
    <script  src="{{asset('assets/assets/js/owl.carousel.min.js')}}"></script>
    <script  src="{{asset('assets/assets/js/slick.min.js')}}"></script>
    <!-- One Page, Animated-HeadLin -->
    <script  src="{{asset('assets/assets/js/wow.min.js')}}"></script>
    <script  src="{{asset('assets/assets/js/animated.headline.js')}}"></script>
    <script  src="{{asset('assets/assets/js/jquery.magnific-popup.js')}}"></script>

    <!-- Date Picker -->
    <script  src="{{asset('assets/assets/js/gijgo.min.js')}}"></script>
    <!-- Nice-select, sticky -->
    <script  src="{{asset('assets/assets/js/jquery.nice-select.min.js')}}"></script>
    <script  src="{{asset('assets/assets/js/jquery.sticky.js')}}"></script>

    <!-- counter , waypoint -->
    <script  src="{{asset('assets/assets/js/jquery.counterup.min.js')}}"></script>
    <script  src="{{asset('assets/assets/js/waypoints.min.js')}}"></script>
    <script  src="{{asset('assets/assets/js/jquery.countdown.min.js')}}"></script>
    <!-- contact js -->
    <script  src="{{asset('assets/assets/js/contact.js')}}"></script>
    <script  src="{{asset('assets/assets/js/jquery.form.js')}}"></script>
    <script  src="{{asset('assets/assets/js/jquery.validate.min.js')}}"></script>
    <script  src="{{asset('assets/assets/js/mail-script.js')}}"></script>
    <script  src="{{asset('assets/assets/js/jquery.ajaxchimp.min.js')}}"></script>

    <!-- Jquery Plugins, main Jquery -->
    <script  src="{{asset('assets/assets/js/plugins.js')}}"></script>
    <script  src="{{asset('assets/assets/js/main.js')}}"></script>
</body>
</html>
