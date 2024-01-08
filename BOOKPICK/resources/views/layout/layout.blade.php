<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @yield ('styles')
        <link href="{{ asset('css/common.css') }}" rel="stylesheet">
        <link href="{{ asset('css/user.css') }}" rel="stylesheet">
        <link href="{{ asset('css/home.css') }}" rel="stylesheet">
        <link href="{{ asset('css/library.css') }}" rel="stylesheet">
        <link href="{{ asset('css/search.css') }}" rel="stylesheet">
        <link href="{{ asset('css/bookdetail.css') }}" rel="stylesheet">
    @yield ('head-scripts')
    {{-- <script src="{{ asset('/js/common.js') }}" defer></script> --}}
    {{-- <script src="{{ asset('/js/home.js') }}" defer></script> --}}
    {{-- <script src="{{ asset('/js/User.js') }}" defer></script> --}}
    {{-- <script src="{{ asset('/js/UserInfoValidation.js') }}" defer></script> --}}
    {{-- <script src="{{ asset('/js/UserRegisterValidation.js') }}" defer></script> --}}
    {{-- <script src="{{ asset('/js/UserVerification.js') }}" defer></script> --}}
    {{-- <script src="{{ asset('/js/bookDetail.js') }}" defer></script> --}}
    <script src="{{ asset('/js/Loading.js') }}" defer></script>
    <title>@yield('title', 'bookpick')</title>
</head>
<body>
    <div class="loading-animation">
        <div class="overlay"></div>
        <div class="loader loading-book">
            <figure class="loading-page"></figure>
            <figure class="loading-page"></figure>
            <figure class="loading-page"></figure>
        </div>
        <p class="loading-p">Reading</p>
    </div>    
    
    <div class="layout_header">
        @include('layout.header')
    </div>
    <div class="layout_body">
        <br>        
        @yield('content')
    </div>
    @yield('defer-js')
</body>
</html>
