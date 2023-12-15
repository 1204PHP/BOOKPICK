@extends('layout.layout')
{{-- layout.blade.php 상속 --}}
@section('title', 'info')
{{-- title로 Login 표기 --}}
@section('content')
{{-- layout.blade.php의 상속을 받지 않고 독자적으로 구성 --}}

    {{-- action="{{ route('user.login.post') }}" --}}    
    {{-- form 태그에서는 의도하지 않은 요청을 악의적으로 전송하여 다른 유저계정에서 실행되는 액션을 
        트리거하는 공격방어 목적으로 @csrf 사용 --}}        
    <form class="info-form" action="{{route('putInfo')}}" method="POST" >
    @csrf
    @method('PUT')
        <div class="info-container">
            <div class="info-input-area">
                <input class="info-input-readonly" type="email" readonly 
                id="u_email" name="u_email" value="">
            </div>
            <div class="info-input-area">
                <input class="info-input" type="password" 
                id="u_password" name="u_password" value="">
                <span class="u_password_errormsg"></span>
            </div>
            <div class="info-input-area">
                <input class="info-input-readonly" type="text" readonly 
                id="u_name" name="u_name" value="">
            </div>
            <div class="info-input-area">
                <input class="info-input-readonly" type="text" readonly 
                id="u_birthdate" name="u_birthdate" value="">
            </div>
            <div class="info-input-area">
                <input class="info-input-readonly" type="tel" readonly 
                id="u_tel" name="u_tel" value="">
            </div>
            <div class="info-input-area">
                <input class="info-input" type="text" 
                id="u_postcode" name="u_postcode" value="">
                <span class="u_postcode_errormsg"></span>
            </div>
            <div class="info-input-area">
                <input class="info-input" type="text" 
                id="u_basic_address" name="u_basic_address" value="">
                <span class="u_basic_address_errormsg"></span>
            </div>
            <div class="info-input-area">
                <input class="info-input" type="text" 
                id="u_detail_address" name="u_detail_address" value="">
                <span class="u_detail_address_errormsg"></span>
            </div>
            <br>         
            <div class="info-button-area">
                <button class="info-button" type="submit">수정</button>
                <button class="info-button" type="button" onclick="{{ route('index') }}">취소</button>
            </div>
        </div>
    </form>
@endsection