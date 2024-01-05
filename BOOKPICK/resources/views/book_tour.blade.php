@extends('layout.layout')
{{-- layout.blade.php 상속 --}}
@section('title', 'index')
{{-- title로 Main 표기 --}}
@section('content')
<div class="tour-container">
    {{-- 광고 영역1 --}}
    <section class="tour-section-1">
        <div class="tour-main-area">
            <div class="tour-main-text-container">
                    <h1 class="tour-main-text">독서 시간을 빛낼 BOOK PICK'</h1>
                    <p class="tour-main-text-p">독서 모험을 더욱 풍성하게!</p>
            </div>
            <div class="tour-main-img-container">
                <img src="{{ asset('img/tour-main.png') }}" alt="...">
            </div>
        </div>
    </section>

    {{-- 광고 영역2 --}}
    <section class="tour-section-2">
        <div class="tour-text-area">
            <h2 class="tour-text-h2">당신을 위한 책들이 정리되어 있어요</h2>
            <p class="tour-text-p">지식의 물결을 따라 새로운 시야를 열어보세요</p>
        </div>
        <!-- 왼쪽에서 오른쪽으로 이동하는 책 이미지 배너 -->
        <div class="tour-banner-container">
            <ul class="left-banner-area">
                @forelse($newBook as $val)
                <li class="left-banner">
                    <img src="{{ $val->b_img_url }}" alt="...">
                </li>
                @empty
                    비어있음
                @endforelse
            </ul>
        </div>

        <!-- 오른쪽에서 왼쪽으로 이동하는 책 이미지 배너 (반대 방향) -->
        <div class="tour-banner-container">
            <ul class="left-banner-reverse-area">
                @forelse($attentionBook as $val)
                <li class="left-banner-reverse">
                    <img src="{{$val->b_img_url}}" alt="...">
                </li>
                @empty
                비어있음
                @endforelse  
            </ul>
        </div>

        <!-- 왼쪽에서 오른쪽으로 이동하는 책 이미지 배너 -->
        <div class="tour-banner-container">
            <ul class="left-banner-area">
                @forelse($bestSellerBook as $val)
                <li class="left-banner">
                    <img src="{{ $val->b_img_url }}" alt="...">
                </li>
                @empty
                    비어있음
                @endforelse
            </ul>
        </div>
        
        {{-- 로그인유도 배너 --}}
        @if(!(Auth::check()))
            <a href="{{ route('getLogin') }}">
                <div class="tour-loginbanner">
                    <p class="tour-loginbanner-p">독서에서 찾은 미소와 감동을 독서기록으로 남겨보세요</p>
                    <p class="tour-text-p">BOOKPICK'은 여러분의 독서 이야기를 기다리고 있어요</p>
                    <span class="loginbanner-loginbtn">로그인하기</span>
                </div>
            </a>
        @endif
    </section>

    {{-- 광고 영역3 --}}
    <section class="tour-section-3">
        <div class="tour-text-area">
            <h2 class="tour-text-h2">북픽과 함께하는 새로운 시작</h2>
            <p class="tour-text-p">성공을 향한 여정, 독서와 함께 떠나보세요</p>
        </div>
        <div class="tour-card-area">
            <div class="tour-card">
                <div class="content">
                    <h2 class="title">쉽지만, 꾸준한 효과!</h2>
                    <p class="copy">이동 중에도 책을 펼치면 언제 어디서나<br>
                        새로운 세계를 열어볼 수 있어요.</p>
                </div>
            </div>
        
            <div class="tour-card">
                <div class="content">
                    <h2 class="title">지금, 시작하세요.</h2>
                    <p class="copy"> 작은 변화가 습관이 되고,<br>
                        습관이 삶을 바꾸기 시작하면,<br>
                        더 큰 성과를 얻을 수 있어요.</p>
                </div>
            </div>
        
            <div class="tour-card">
                <div class="content">
                    <h2 class="title">독서 후, 기록하세요.</h2>
                    <p class="copy">책을 읽고, 그 감동과 생각을 적어주세요.<br>
                        책의 내용에 대해 기억할 확률이<br>
                        훨씬 높아져요.</p>
                </div>
            </div>
        
            <div class="tour-card">
                <div class="content">
                    <h2 class="title">독서, 건강해져요. </h2>
                    <p class="copy">스트레스를 효과적으로 완화하고 싶다면,<br>
                        독서가 최고의 친구예요.</p>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('defer-js')
    <script src="{{ asset('/js/common.js') }}" defer></script>
    <script src="{{ asset('/js/tour.js') }}" defer></script>
@endsection