@extends('layout.layout')
{{-- layout.blade.php 상속 --}}
@section('title', 'register')
{{-- title로 Login 표기 --}}
@section('content')
{{-- layout.blade.php의 상속을 받지 않고 독자적으로 구성 --}}

    {{-- action="{{ route('user.login.post') }}" --}}    
    {{-- form 태그에서는 의도하지 않은 요청을 악의적으로 전송하여 다른 유저계정에서 실행되는 액션을 
        트리거하는 공격방어 목적으로 @csrf 사용 --}}
        
    <form class="register-form" action="" method="POST" >
    @csrf
        <div class="register-container">
            <div class="register-input-area">
                <input class="register-input" type="email" name="u_email" required placeholder="이메일 주소">
                <span>유효하지 않은 날짜입니다.</span>
            </div>
            <div class="register-input-area">
                <input class="register-input" type="password" name="u_password" required placeholder="비밀번호">
                <span>유효하지 않은 날짜입니다.</span>
            </div>
            <div class="register-input-area">
                <input class="register-input" type="text" name="u_name" required placeholder="이름">
                <span>유효하지 않은 날짜입니다.</span>
            </div>
            <div class="register-input-area">
                <input class="register-input" type="text" name="u_birthdate" required placeholder="생년월일 YYYY:MM:DD"
                id="birthdate" maxlength="10">
                <span>유효하지 않은 날짜입니다.</span>
            </div>
            <div class="register-input-area">
                <input class="register-input" type="tel" name="u_tel" required placeholder="휴대폰 번호">
                <span>유효하지 않은 날짜입니다.</span>
            </div>
            <div class="register-input-area">
                <input class="register-input" type="text" required placeholder="우편번호">
                <span>유효하지 않은 날짜입니다.</span>
            </div>
            <div class="register-input-area">
                <input class="register-input" type="text" required placeholder="기본주소">
                <span>유효하지 않은 날짜입니다.</span>
            </div>
            <div class="register-input-area">
                <input class="register-input" type="text" required placeholder="상세주소">
                <span>유효하지 않은 날짜입니다.</span>
            </div>
            




            <br>
            <div class="register-button-area">
                <button class="register-button" type="submit">가입하기</button>
            </div>
            <div class="register-text">
                <span>이미 회원이신가요?</span> <a class="register-login-link" href="{{ route('login') }}">로그인하기</a>
            </div>
        </div>
    </form>
@endsection