@extends('layout.layout')
{{-- layout.blade.php 상속 --}}
@section('title', 'login')
{{-- title로 Login 표기 --}}
@section('content')
{{-- layout.blade.php의 상속을 받지 않고 독자적으로 구성 --}}
<form class="login-form" action="{{route('postLogin')}}" method="POST" >
	{{-- action="{{ route('user.login.post') }}" --}}
	@csrf
	{{-- form 태그에서는 의도하지 않은 요청을 악의적으로 전송하여 다른 유저계정에서 실행되는 액션을 
		트리거하는 공격방어 목적으로 @csrf 사용 --}}
	<div class="login-container">
		<p class="login-p">BOOK PICK'</p>
		<br>
		<div class="login-kakaologin-button-area">
			
		</div>
		<div class="login-input-area">
		<input class="login-input" type="text" id="u_email" name="u_email" value=""
		required autocomplete="off" placeholder="이메일 주소">
		</div>
		<div class="login-input-area">
		<input class="login-input" type="password" id="u_password" name="u_password" 
		required autocomplete="off" placeholder="비밀번호">
		</div>
		<div class="login-button-area">
			<button class="login-button" type="submit">로그인</button>
			<button class="login-kakaologin-button" type="button">카카오계정으로 로그인</button>
			<span class="login-span">개인정보 보호를 위해 공용 PC에서 사용 시 SNS계정의 로그아웃 상태를 꼭 확인해 주세요.</span> 
			<button class="login-register-button" type="button" onclick="{{ route('getRegister') }}">회원가입</button>
		</div>
	</div>
</form>
@endsection