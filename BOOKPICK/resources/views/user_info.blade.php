@extends('layout.layout')
{{-- layout.blade.php 상속 --}}
@section('title', 'info')
{{-- title로 Login 표기 --}}
@section('content')
{{-- layout.blade.php의 상속을 받지 않고 독자적으로 구성 --}}

    {{-- action="{{ route('user.login.post') }}" --}}    
    {{-- form 태그에서는 의도하지 않은 요청을 악의적으로 전송하여 다른 유저계정에서 실행되는 액션을 
        트리거하는 공격방어 목적으로 @csrf 사용 --}}        
    <form class="info-form" action="" method="POST" >
    @csrf
    @method('PUT')
        <div class="info-container">
            <div class="info-input-area">
                <input class="info-input-readonly" type="email" readonly placeholder="이메일 주소">
            </div>
            <div class="info-input-area">
                <input class="info-input" type="password" placeholder="비밀번호">
            </div>
            <div class="info-input-area">
                <input class="info-input" type="password" placeholder="비밀번호 확인">
            </div>
            <div class="info-input-area">
                <input class="info-input-readonly" type="text" readonly placeholder="이름">
            </div>
            <div class="info-input-area">
                <input class="info-input-readonly" type="text" readonly placeholder="생년월일 YYYY:MM:DD">
            </div>
            <div class="info-input-area">
                <input class="info-input-readonly" type="tel" readonly placeholder="휴대폰 번호">
            </div>
            <div class="info-input-area">
                <input class="info-input" type="text" placeholder="우편번호">
            </div>
            <div class="info-input-area">
                <input class="info-input" type="text" placeholder="기본주소">
            </div>
            <div class="info-input-area">
                <input class="info-input" type="text" placeholder="상세주소">
            </div>
            <br>         
            <div class="info-button-area">
                <button class="info-button" type="submit">수정</button>
            </div>
        </div>
    </form>
@endsection