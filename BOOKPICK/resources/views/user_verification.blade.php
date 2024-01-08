@extends('layout.layout')
{{-- layout.blade.php 상속 --}}
@section('title', '이메일 검증')
{{-- title로 Login 표기 --}}
@section('content')
{{-- layout.blade.php의 상속을 받지 않고 독자적으로 구성 --}}
<div class="login-container">
	<a href="{{ route('index') }}"><p class="login-h1">BOOK PICK'</p></a>
    <div class="login-input-area">
    <p>이메일 주소 확인</p>
    </div>
    <form action="{{ route('sendVerification') }}" method="POST">
    @csrf
        <input class="preregister-input" type="email" id="u_email" name="u_email" 
        placeholder="*이메일" autocomplete="off">
        <button type="submit">전송</button>
    </form>

    <div class="login-input-area">
    <p>이메일 재요청. 하단 버튼 클릭</p>
    </div>
    <form method="POST" action="{{ route('reSendVerification') }}">
    @csrf
        <div class="login-button-area">
            <button class="login-button" type="submit">이메일 검증 재전송</button>
        </div>
    </form>
</div>
@endsection
