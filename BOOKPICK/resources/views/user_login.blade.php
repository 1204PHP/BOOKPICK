@extends('layout.layout')
{{-- layout.blade.php 상속 --}}
@section('title', 'login')
{{-- title로 Login 표기 --}}
@section('content')
{{-- layout.blade.php의 상속을 받지 않고 독자적으로 구성 --}}
<form class="login-form" action="" method="POST" >
	{{-- action="{{ route('user.login.post') }}" --}}
	@csrf
	{{-- form 태그에서는 의도하지 않은 요청을 악의적으로 전송하여 다른 유저계정에서 실행되는 액션을 
		트리거하는 공격방어 목적으로 @csrf 사용 --}}
	<div class="login-container">
		<p class="login-p">간편로그인</p>
		<br>
		<div class="login-kakaologin-button-area">
			<button class="login-kakaologin-button" type="button">카카오계정으로 로그인</button>
		</div>
		<div class="login-line-or-line">
			<div class="login-line"></div>
			<span class="login-or">OR</span>
			<div class="login-line"></div>
		</div>
		<p class="login-p">이메일 로그인</p>
		<br>
		<div class="login-input-area">
		<input class="login-input" type="text" id="email" name="u_email" 
		required autocomplete="off" placeholder="이메일 주소">
		<span class="u_mail_errormsg"></span>
		</div>
		<div class="login-input-area">
		<input class="login-input" type="password" id="password" name="u_password" 
		required autocomplete="off" placeholder="비밀번호">
		<span class="u_password_errormsg"></span>
		</div>
		<br>
		<div class="login-button-area">
			<button class="login-button" type="submit">로그인</button>
		</div>
		<div class="login-text">
			<span>북픽에 처음이신가요?</span> <a class="login-register-link" href="{{ route('register') }}">회원가입하기</a>
		</div>
	</div>
</form>
@endsection