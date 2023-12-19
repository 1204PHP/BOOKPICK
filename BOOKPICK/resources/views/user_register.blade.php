@extends('layout.layout')
{{-- layout.blade.php 상속 --}}
@section('title', '회원가입')
{{-- title로 Login 표기 --}}
@section('content')
{{-- layout.blade.php의 상속을 받지 않고 독자적으로 구성 --}}
    <form class="register-form" action="{{route('postRegister')}}" method="POST">
    @csrf
        <div class="register-container">
            <p class="register-h1">북픽 가입</p>
            <p class="register-h2">이메일은 아이디로 사용됩니다</p>
            <div class="register-input-area">
                <input class="register-input" type="email" id="u_email" name="u_email" value="" 
                placeholder="이메일 주소" autocomplete="off">
                <span class="u_mail_errormsg"></span>
            </div>
            <div class="register-input-area">
                <input class="register-input" type="password" id="u_password" name="u_password" 
                placeholder="비밀번호" autocomplete="off">
                <span class="u_password_errormsg"></span>
            </div>
            <div class="register-input-area">
                <input class="register-input" type="text" id="u_name" name="u_name" 
                maxlength="50" placeholder="이름" autocomplete="off">
                <span class="u_name_errormsg"></span>
            </div>
            <div class="register-input-area">
                <input class="register-input" type="text" id="u_birthdate" name="u_birthdate" 
                maxlength="8" placeholder="생년월일" autocomplete="off">
                <span class="u_birthdate_errormsg"></span>
            </div>
            <div class="register-input-area">
                <input class="register-input" type="tel" id="u_tel" name="u_tel" 
                maxlength="11" placeholder="휴대폰 번호" autocomplete="off">
                <span class="u_tel_errormsg"></span>
            </div>
            <div class="register-input-postcode-area">
                <div class="register-input-area">
                    <input class="register-postcode-input" type="text" id="u_postcode" name="u_postcode"
                    maxlength="5" placeholder="우편번호" autocomplete="off">
                    <span class="u_postcode_errormsg"></span>
                </div>
                {{-- <button class="register-postcode-button" type="button">주소검색</button> --}}
            </div>
            <div class="register-input-area">
                <input class="register-input" type="text" id="u_basic_address" name="u_basic_address"
                placeholder="기본주소" autocomplete="off">
                <span class="u_basic_address_errormsg"></span>
            </div>
            <div class="register-input-area">
                <input class="register-input" type="text" id="u_detail_address" name="u_detail_address"
                placeholder="상세주소" autocomplete="off">
            </div>
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="error-text">{{ $error }}</div>
                @endforeach
		    @endif
            <div class="register-button-area">
                <button class="register-button" type="submit">회원가입</button>
            </div>
            <div class="register-text">
                <span>이미 회원이신가요?</span> <a class="register-login-link" href="{{ route('getLogin') }}">로그인하기</a>
            </div>
        </div>
    </form>
@endsection