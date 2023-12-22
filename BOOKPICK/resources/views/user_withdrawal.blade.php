@extends('layout.layout')
{{-- layout.blade.php 상속 --}}
@section('title', '회원탈퇴')
{{-- title로 Main 표기 --}}
@section('content')
    <form class="withdrawal-form" action="{{route('deleteWithdrawal')}}" method="POST">
        @csrf
        @method('DELETE')
        <div class="withdrawal-container">
            <p class="withdrawal-h1">북픽 회원 탈퇴하기 전, 다음 내용을 꼭! 확인해주세요</p>
            <div class="withdrawal-area">
                <div class="withdrawal-text-area">
                    <span class="withdrawal-h2">북픽 계정 탈퇴</span>
                    <div class="withdrawal-li-area">
                        <li class="withdrawal-li">탈퇴 시 해당 계정으로 작성된 댓글을 수정하거나 삭제, 복원할 수 없습니다.</li>
                        <li class="withdrawal-li">삭제를 원하는 댓글이 있다면 탈퇴 전 삭제해주세요.</li>
                        <li class="withdrawal-li">회원 탈퇴 시 더 이상 북픽 서비스 사용이 불가능하며, 탈퇴 처리됩니다.</li>
                    </div>
                </div>
                <div class="withdrawal-button-area">
                    <button class="withdrawal-button" type="submit">북픽 탈퇴</button>
                    <a class="withdrawal-index-button" href="{{ route('index') }}">취소</a>
                </div>   
            </div>             
        </div>
    </form>
@endsection

@section('defer-js')
    <script src="{{ asset('/js/UserValidation.js') }}" defer></script>
@endsection


