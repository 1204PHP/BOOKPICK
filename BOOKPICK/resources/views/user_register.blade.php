@extends('layout.layout')
{{-- layout.blade.php 상속 --}}
@section('title', 'Register')
{{-- title로 Login 표기 --}}
@section('content')
{{-- layout.blade.php의 상속을 받지 않고 독자적으로 구성 --}}
<form class="register-form" action="" method="POST" >
    {{-- action="{{ route('user.login.post') }}" --}}
    @csrf
    {{-- form 태그에서는 의도하지 않은 요청을 악의적으로 전송하여 다른 유저계정에서 실행되는 액션을 
        트리거하는 공격방어 목적으로 @csrf 사용 --}}
    <div class="register-container">
        <input class="register-input" type="text" id="u_email" name="u_email" 
        autocomplete="off" placeholder="이메일 주소">
        <input class="register-input" type="password" id="u_password" name="u_password"
        autocomplete="off" placeholder="비밀번호">
        <input class="register-input" type="password" id="u_password_confirm" name="u_password_confirm" 
        autocomplete="off" placeholder="비밀번호 확인">
        <input class="register-input" type="text" id="u_nickname" name="u_nickname" 
        autocomplete="off" placeholder="닉네임">
        <input class="register-input" type="number" id="u_postcode" name="u_postcode" 
        pattern="[0-9]*" inputmode="numeric" maxlength="10" oninput="limitPostalCodeLength(this)"
        autocomplete="off" placeholder="우편번호">
        <input class="register-input" type="text" id="u_basic_address" name="u_basic_address" 
        autocomplete="off" placeholder="기본주소">
        <input class="register-input" type="text" id="u_detail_address" name="u_detail_address" 
        autocomplete="off" placeholder="상세주소">

        <div class="register-gender-container">
            <button class="register-gender-button" type="button">남자</button>
            <button class="register-gender-button" type="button">여자</button>
            <input type="hidden" id="selectedGender" name="u_gender" value="">
        </div>

        <input class="register-input" type="text" id="u_name" name="u_name" 
        autocomplete="off" placeholder="이름">
        
        <input class="register-input" id="date" name="u_birthdate" 
        maxlength="10" autocomplete="off" placeholder="YYYY-MM-DD" oninput="onInputHandler()">
        <span class="register-warning">유효하지 않은 날짜입니다.</span>

        <input class="register-input" type="tel" id="u_tel" name="u_tel" 
        autocomplete="off" placeholder="휴대폰 번호">

        <button class="register-button" type="submit">가입하기</button>
        <div class="register-text">
            <span>이미 회원이신가요?</span> <a class="register-login-link" href="">로그인하기</a>
        </div>
    </div>
</form>
@endsection