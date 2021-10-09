<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Scripts -->
        <script src="{{ asset('user/js/app.js') }}"></script>
        <script src="{{ asset('user/js/jquery.cookie.js') }}"></script>
        <script src="{{ asset('user/js/modalcontents.js')}}"></script>
        <script src="{{ asset('user/js/common.js') }}"></script>
        <script src="{{ asset('user/js/jquery.bxslider.js') }}"></script>
        <script src="{{ asset('user/js/lazyload.js') }}"></script>
        <script src="{{ asset('user/js/lity.min.js') }}"></script>
        <script src="{{ asset('user/js/stats.js') }}"></script>
    @yield('page_js')

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('user/css/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('user/css/common.css') }} ">
    <link rel="stylesheet" href="{{ asset('user/css/layout.css') }}">
    <link rel="stylesheet" href="{{ asset('user/css/lity.min.css') }}">
    <link rel="stylesheet" href="{{ asset('user/css/app.css') }} ">
    @yield('page_css')
</head>
<body>
    <div id="app">
        <header class="p-3 bg-dark text-center text-white">
            @yield('header')
        </header>
        
        <div id="particles-js" style="background: #333;"></div>
        <script src="{{ asset('user/js/particles.js') }}"></script> 
        <script src="{{ asset('user/js/page/auth.js') }}"></script> 
        @include('layouts.flash-message')
        <main class="py-4 fadeout mt-5">
            @yield('content')
        </main>
        <footer class="bg-white">
            <ul id="gnav">
                <li><a href="{{ route('contact') }}"><img src="{{ asset('user/img/common/nav3.png') }}" alt=""><p>Contact</p></a></li>
                <li><a href="{{ route('chat') }}"><img src="{{ asset('user/img/common/nav4.png') }}" alt=""><p>Chat</p></a></li>
                <li><a href="{{ route('profile') }}"><img src="{{ asset('user/img/common/nav5.png') }}" alt=""><p>Profile</p></a></li>
            </ul>
        </footer>
    </div>
</body>
</html>
