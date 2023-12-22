@extends('layout.layout')
{{-- layout.blade.php 상속 --}}
@section('title', '회원정보 수정')
{{-- title로 Main 표기 --}}
@section('content')
{{-- layout.blade.php의 상속을 받지 않고 독자적으로 구성 --}}

<form class="password-reconfirm-form" action="{{route('postPasswordReconfirm')}}" method="POST">
	@csrf
	{{-- form 태그에서는 의도하지 않은 요청을 악의적으로 전송하여 다른 유저계정에서 실행되는 액션을 
		트리거하는 공격방어 목적으로 @csrf 사용 --}}
	<div class="password-reconfirm-container">
		<a href="{{ route('index') }}"><p class="login-h1">BOOK PICK'</p></a>
		<div class="password-reconfirm-area">
            <input class="password-reconfirm-input" type="password" id="u_password" name="u_password" 
            autocomplete="off" placeholder="비밀번호를 입력해주세요">
		</div>
		@include('layout.user_error_message')
		<div class="password-reconfirm-button-area">
            <span class="password-reconfirm-span">회원정보를 안전하게 보호하기 위해 비밀번호를 한번 더 확인해주세요</span>
			<button type="submit">회원정보 수정</button>
		</div>
	</div>
</form>
@endsection

@section('defer-js')
    <script src="{{ asset('/js/UserValidation.js') }}" defer></script>
@endsection