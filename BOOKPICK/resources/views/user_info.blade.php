@extends('layout.layout')
{{-- layout.blade.php 상속 --}}
@section('title', '회원정보 수정')
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
            <p class="info-h1">회원정보 수정</p>

            <div class="info-input-area">
                <input class="info-input-readonly" type="email" readonly 
                id="u_email" name="u_email" value={{ $userdata->u_email }}>
            </div>
            
            <div class="info-input-area">
                <input class="info-input" type="password" 
                id="new_password" name="new_password" maxlength="20" placeholder="변경 비밀번호">
                <span class="errormsg new_password_errormsg"></span> 
            </div>
            
            <div class="info-input-area">
                <input class="info-input" type="password" 
                id="password_confirm" name="password_confirm" maxlength="20" placeholder="비밀번호 확인">
                <span class="errormsg password_confirm_errormsg"></span>
            </div>

            <div class="info-input-area">
                <input class="info-input-readonly" type="text" readonly 
                id="u_name" name="u_name" value={{ $userdata->u_name }}>
            </div>

            <div class="info-input-area">
                <input class="info-input-readonly" type="text" readonly 
                id="u_birthdate" name="u_birthdate" value={{ $userdata->u_birthdate }}>
            </div>

            <div class="info-input-area">
                <input class="info-input-readonly" type="tel" readonly 
                id="u_tel" name="u_tel" value={{ $userdata->u_tel }}>
            </div>

            <button class="info-postcode-button" type="button" 
            id="info-postcode-button" onclick="addressSearch()">주소검색</button>

            <div class="info-input-postcode-area">
                <div class="info-input-area">
                    <input class="info-input" type="text" id="u_postcode" name="u_postcode"
                    value={{ $userdata->u_postcode }} maxlength="5">
                    <span class="errormsg u_postcode_errormsg"></span>
                </div>                
            </div>

            <div class="info-input-area">
                <input class="info-input" type="text" 
                id="u_basic_address" name="u_basic_address" value={!!$userdata->u_basic_address!!}>
                <span class="errormsg u_basic_address_errormsg"></span>
            </div>

            <div class="info-input-area">
                <input class="info-input" type="text" 
                id="u_detail_address" name="u_detail_address" value={!! $userdata->u_detail_address !!}>
                <span class="errormsg u_detail_address_errormsg"></span>
            </div>

            <span>@include('layout.user_error_message')</span>  
            <span class="errormsg" id="info_errormsg"></span>
            <div class="info-button-area">
                <button class="info-button" id="info-button" type="submit">수정하기</button>
            </div>
            <a class="info-withdrawal-link" href="{{ route('deleteWithdrawal') }}">회원탈퇴</a>
        </div>
    </form>
@endsection

@section('defer-js')
    <script src="{{ asset('/js/UserInfoValidation.js') }}" defer></script>
    <script src="{{ asset('/js/UserAddress.js') }}" defer></script>
    <script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var infoUpdate = {!! json_encode(session('infoUpdate')) !!};
            
            if (infoUpdate) {
                alert(infoUpdate);
            }
        });
    </script>
@endsection
