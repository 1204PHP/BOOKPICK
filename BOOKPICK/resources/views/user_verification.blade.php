@extends('layout.layout')
{{-- layout.blade.php 상속 --}}
@section('title', '이메일 검증')
{{-- title로 Login 표기 --}}
@section('content')
{{-- layout.blade.php의 상속을 받지 않고 독자적으로 구성 --}}
<div class="verification-container">
	<a href="{{ route('index') }}"><p class="verification-h1">BOOK PICK'</p></a>
    <div class="verification-input-area">
    <p class="verification-h2">아이디로 사용하실 이메일을 입력해주세요</p>
    </div>
    <form class="verification-form" action="{{ route('sendVerification') }}" method="POST">
    @csrf
        <div class="register-input-area">
            <input class="verification-input" type="email" id="u_email" name="u_email" 
            placeholder="이메일 주소" autocomplete="off" value="{{ isset($u_email)?$u_email:'' }}">
            <button id="emailConfirmButton" class="register-email-button" type="button">중복 확인</button>
            <span class="errormsg u_email_errormsg"></span>
        </div>
        <div class="verification-button-area">
            <button id="verification-button" type="submit">인증 이메일 전송</button>
            <button type="button" class="reverification-link" onclick="action='{{ route('reSendVerification') }}'; submit();">인증 이메일 재전송</button>
        </div>
    </form>
</div>
@endsection

@section('defer-js')
<script src="{{ asset('/js/UserVerification.js') }}" defer></script>

@endsection