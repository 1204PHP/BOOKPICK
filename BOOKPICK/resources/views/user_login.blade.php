@extends('layout.layout')
{{-- layout.blade.php 상속 --}}
@section('title', '로그인')
{{-- title로 Login 표기 --}}
@section('content')
{{-- layout.blade.php의 상속을 받지 않고 독자적으로 구성 --}}
<div class="login-container">
	<form class="login-form" action="{{route('postLogin')}}" method="POST">
		@csrf
		{{-- form 태그에서는 의도하지 않은 요청을 악의적으로 전송하여 다른 유저계정에서 실행되는 액션을 
			트리거하는 공격방어 목적으로 @csrf 사용 --}}	
		<a href="{{ route('index') }}"><p class="login-h1">BOOK PICK'</p></a>
		<div class="login-input-area">
		<input class="login-input" type="text" id="u_email" name="u_email" value=""
		autocomplete="off" placeholder="이메일 주소">
		</div>
		<div class="login-input-area">
		<input class="login-input" type="password" id="u_password" name="u_password" 
		autocomplete="off" placeholder="비밀번호">
		</div>
		@include('layout.user_error_message')
		<div class="login-button-area">
			<button class="login-button" type="submit">로그인</button>
			<button class="login-kakaologin-button" type="button">카카오계정으로 로그인</button>			
		</div>
		<div class="login-button-area-1">
			<span class="login-span">개인정보 보호를 위해 공용 PC에서 사용 시<br>
				SNS계정의 로그아웃 상태를 꼭 확인해 주세요.</span> 			
		</div>	
		<div class="login-button-area">
			<button type="button" class="login-register-button" onclick="location.href='{{ route('getRegister') }}'">회원가입</button>
		</div>	
	</form>
</div>
@endsection

