@extends('layout.layout')
{{-- layout.blade.php 상속 --}}
@section('title', '회원정보 수정')
{{-- title로 Main 표기 --}}
@section('content')
{{-- layout.blade.php의 상속을 받지 않고 독자적으로 구성 --}}

<div class="password-reconfirm-container">
	<form class="password-reconfirm-form" action="{{route('postPasswordReconfirm')}}" method="POST">
		@csrf
		{{-- form 태그에서는 의도하지 않은 요청을 악의적으로 전송하여 다른 유저계정에서 실행되는 액션을 
			트리거하는 공격방어 목적으로 @csrf 사용 --}}
	
		<a href="{{ route('index') }}"><p class="password-reconfirm-h1">BOOK PICK'</p></a>
		<div class="password-reconfirm-area">
			<input class="password-reconfirm-input" type="password" id="u_password" name="u_password" 
			autocomplete="off" placeholder="비밀번호를 입력해주세요">
		</div>
		@include('layout.user_error_message')
		<div class="password-reconfirm-button-area">
			<span class="password-reconfirm-span">회원정보를 안전하게 보호하기 위해 비밀번호를 한번 더 확인해주세요</span>
		</div>
		<button class="password-reconfirm-info-button" type="submit">회원정보 수정</button>
	</form>
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