@extends('layout.layout')
{{-- layout.blade.php 상속 --}}
@section('title', 'Login')
{{-- title로 Login 표기 --}}
@section('main')
{{-- layout.blade.php의 상속을 받지 않고 독자적으로 구성 --}}
<main>
	<form action="" method="POST" >
		{{-- action="{{ route('user.login.post') }}" --}}
		@csrf
		{{-- form 태그에서는 의도하지 않은 요청을 악의적으로 전송하여 다른 유저계정에서 실행되는 액션을 
			트리거하는 공격방어 목적으로 @csrf 사용 --}}
		<div class="LoginArea">
			<p>이메일 로그인</p>
			<input type="text" id="email" name="email" autocomplete="off" placeholder="이메일 주소">
			<br>
			<input type="password" id="password" name="password" autocomplete="off" placeholder="비밀번호">
			<br>
			<button type="submit">로그인</button>
			<p>북픽에 처음이신가요? <a href="">회원가입하기</a></p>
		</div>
	</form>

</main>
@endsection