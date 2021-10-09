<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

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
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <div id="particles-js" style="background: #333;"></div>
        <script src="{{ asset('user/js/particles.js') }}"></script> 
        <script src="{{ asset('user/js/page/auth.js') }}"></script> 
        @include('layouts.flash-message')

        <main class="py-4 fadeout">
            @yield('content')
        </main>
    </div>
</body>
</html>
