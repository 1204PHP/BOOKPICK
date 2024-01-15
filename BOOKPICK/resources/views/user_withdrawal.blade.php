@extends('layout.layout')
{{-- layout.blade.php 상속 --}}
@section('title', '회원탈퇴')
{{-- title로 Main 표기 --}}
@section('content')
<div class="withdrawal-container">
    <form class="withdrawal-form" action="{{route('deleteWithdrawal')}}" method="POST">
        @csrf
        @method('DELETE')
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
                <button class="withdrawal-button" type="submit" onclick="return confirmWithdrawal()">북픽 탈퇴</button>
                <button type="button" class="withdrawal-main-button" onclick="location.href='{{ route('index') }}'">취소</button>
            </div>   
        </div>             
    </form>
</div>
@endsection

@section('defer-js')
    <script src="{{ asset('/js/User.js') }}" defer></script>
@endsection

@section('footer')
        
    <footer class="user-footer">
        <div class="footer-container">
            <div class="footer-section-left">
                <div class="footer-logo">
                    <a href="{{ route('index') }}">BOOK PICK'</a>
                </div><br>
                <p class="footer-text">제작자 : 오성찬, 여중기, 신호철</p>
                <p class="footer-text">그린컴퓨터아트학원 | 대구광역시 중구 중앙대로 394 제일빌딩 5F</p>
                <p class="footer-text">평일 09:00 ~ 22:30 | 토요일 09:00 ~ 18:30 | 대표전화 : 053.572.1005</p>
                <p class="footer-copytext">&copy; 2023~2024 BOOKPICK' Corp. All rights reserved.</p>
            </div>
            <div class="footer-section-right">
                <p class="footer-copytext-right">&copy; 2023~2024 BOOKPICK' Corp. All rights reserved.</p>
                <div class="footer-sns">
                    <a href=""><img src="https://api.iconify.design/entypo-social/youtube-with-circle.svg?color=%23666" alt=""></a>
                    <a href=""><img src="https://api.iconify.design/entypo-social/instagram-with-circle.svg?color=%23666" alt=""></a>
                    <a href=""><img src="https://api.iconify.design/entypo-social/facebook-with-circle.svg?color=%23666" alt=""></a>
                    <a href=""><img src="https://api.iconify.design/ant-design/twitter-circle-filled.svg?color=%23666" alt=""></a>
                </div>
                <div class="footer-app">
                    <a href=""><img src="https://www.koreanair.com/content/dam/koreanair/ko/main/banner-googleplay.svg" alt=""></a>
                    <a href=""><img src="https://www.koreanair.com/content/dam/koreanair/ko/main/banner-appstore.svg" alt=""></a>
                </div>
            </div>
        </div>
    </footer>
@endsection
