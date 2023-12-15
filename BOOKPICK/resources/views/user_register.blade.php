@extends('layout.layout')
{{-- layout.blade.php 상속 --}}
@section('title', 'register')
{{-- title로 Login 표기 --}}
@section('content')
{{-- layout.blade.php의 상속을 받지 않고 독자적으로 구성 --}}

    {{-- action="{{ route('user.login.post') }}" --}}    
    {{-- form 태그에서는 의도하지 않은 요청을 악의적으로 전송하여 다른 유저계정에서 실행되는 액션을 
        트리거하는 공격방어 목적으로 @csrf 사용 --}}
        
    <form class="register-form" action="{{route('postRegister')}}" method="POST" >
    @csrf
        <div class="register-container">
            <div class="register-input-area">
                <input class="register-input" type="email" id="u_email" name="u_email" 
                required placeholder="이메일 주소">
                <span class="u_mail_errormsg"></span>
            </div>
            <div class="register-input-area">
                <input class="register-input" type="password" id="u_password" name="u_password" 
                required placeholder="비밀번호">
                <span class="u_password_errormsg"></span>
            </div>
            <div class="register-input-area">
                <input class="register-input" type="text" id="u_name" name="u_name" 
                required placeholder="이름">
                <span class="u_name_errormsg"></span>
            </div>
            <div class="register-input-area">
                <input class="register-input" type="text" id="u_birthdate" name="u_birthdate" 
                required placeholder="생년월일 YYYY:MM:DD"
                id="birthdate" maxlength="10">
                <span class="u_birthdate_errormsg"></span>
            </div>
            <div class="register-input-area">
                <input class="register-input" type="tel" id="u_tel" name="u_tel" 
                required placeholder="휴대폰 번호">
                <span class="u_tel_errormsg"></span>
            </div>
            <div class="register-input-area">
                <input class="register-input" type="text" id="u_postcode" name="u_postcode"
                required placeholder="우편번호">
                <span class="u_postcode_errormsg"></span>
            </div>
            <div class="register-input-area">
                <input class="register-input" type="text" id="u_basic_address" name="u_basic_address"
                required placeholder="기본주소">
                <span class="u_basic_address_errormsg"></span>
            </div>
            <div class="register-input-area">
                <input class="register-input" type="text" id="u_detail_address" name="u_detail_address"
                required placeholder="상세주소">
                <span class="u_detail_address_errormsg"></span>
            </div>
            <br>
            <div class="register-button-area">
                <button class="register-button" type="submit">가입하기</button>
            </div>
            <div class="register-text">
                <span>이미 회원이신가요?</span> <a class="register-login-link" href="{{ route('getLogin') }}">로그인하기</a>
            </div>
        </div>
    </form>
@endsection