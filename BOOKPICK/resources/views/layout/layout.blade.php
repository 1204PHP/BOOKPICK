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
    <script src="{{ asset('/js/search.js') }}" defer></script>
    {{-- <script src="{{ asset('/js/Loading.js') }}" defer></script> --}}
    <title>@yield('title', 'bookpick')</title>
</head>
<body>   
    <div class="layout_header">
        @include('layout.header')
    </div>
    <div class="layout_body">
        <br>        
        @yield('content')
    </div>
    <div class="layout_footer">
        @section('footer')
        <footer>
            <div class="footer-container">
                <div class="footer-section-left">
                    <div class="footer-logo">
                        <a href="{{ route('index') }}">BOOK PICK'</a>
                    </div><br>
                    <p class="footer-text">제작자 : 오성찬, 여중기, 신호철</p>
                    <p class="footer-text">그린컴퓨터아트학원 | 대구광역시 중구 중앙대로 394 제일빌딩 5F</p>
                    <p class="footer-text">평일 09:00 ~ 22:30 | 토요일 09:00 ~ 18:30 | 대표전화 : 053.572.1005</p>
                    <p class="footer-copytext">&copy; 2023~2024 BOOKPICK' Corp. All rights reserved.</p>
                </div>
                <div class="footer-section-right">
                    <p class="footer-copytext-right">&copy; 2023~2024 BOOKPICK' Corp. All rights reserved.</p>
                    <div class="footer-sns">
                        <a href=""><img src="https://api.iconify.design/entypo-social/youtube-with-circle.svg?color=%23666" alt=""></a>
                        <a href=""><img src="https://api.iconify.design/entypo-social/instagram-with-circle.svg?color=%23666" alt=""></a>
                        <a href=""><img src="https://api.iconify.design/entypo-social/facebook-with-circle.svg?color=%23666" alt=""></a>
                        <a href=""><img src="https://api.iconify.design/ant-design/twitter-circle-filled.svg?color=%23666" alt=""></a>
                    </div>
                    <div class="footer-app">
                        <a href=""><img src="https://www.koreanair.com/content/dam/koreanair/ko/main/banner-googleplay.svg" alt=""></a>
                        <a href=""><img src="https://www.koreanair.com/content/dam/koreanair/ko/main/banner-appstore.svg" alt=""></a>
                    </div>
                </div>
            </div>
        </footer>
        @show
    </div>
    @yield('defer-js')
</body>
</html>
