@extends('layout.layout')
{{-- layout.blade.php 상속 --}}
@section('title', '이메일 검증')
{{-- title로 Login 표기 --}}
@section('content')
{{-- layout.blade.php의 상속을 받지 않고 독자적으로 구성 --}}
<div class="verification-body">
    <div class="verification-container">
        <a href="{{ route('index') }}"><p class="verification-h1">BOOK PICK'</p></a>
        <div class="verification-input-area">
            <p class="verification-h2">이메일 입력 후 이메일 전송 버튼을 클릭하여 이메일인증을 진행해주세요</p>
        </div>
        <form class="verification-form" action="{{ route('sendVerification') }}" method="POST">
        @csrf
            <div class="verification-input-area">
                <input class="verification-input" type="email" id="u_email" name="u_email" 
                placeholder="이메일 주소" autocomplete="off" value="{{ isset($u_email)?$u_email:'' }}">
                <button id="emailConfirmButton" class="register-email-button" type="button">중복 확인</button>            
            </div>        
            <button id="verification-button" type="submit">인증 이메일 전송</button><br>        
            <button type="button" class="reverification-link" 
            onclick="action='{{ route('reSendVerification') }}'; submit();">재전송</button>        
        </form>
    </div>
</div>
@endsection

@section('footer')
    <footer class="user-footer">
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
@endsection

@section('defer-js')
<script src="{{ asset('/js/UserVerification.js') }}" defer></script>

@endsection
