@extends('layout.layout')
{{-- layout.blade.php 상속 --}}
@section('title', 'home')
{{-- title로 Main 표기 --}}
@section('content')
<div class="tour-container">
    {{-- 광고 영역1 --}}
    <section class="tour-section-1">
        <div class="tour-text-area">
            <div class="tour-img-text">
                <img src="{{ asset('img/tour2.png') }}" alt="...">
                <div class="tour-text-area-1">
                    <h1 class="tour-text">독서 시간을 빛낼 
                        <br>BOOK PICK'
                    </h1>
                    <p class="tour-text-1">독서 모험을 더욱 풍성하게 </p>
                </div>
            </div>
        </div>
    </section>

    {{-- 광고 영역2 --}}
    <section class="tour-section-2">
        <div class="tour-text-area">
            <h2 class="tour-text-h2">당신을 기다리는 수 많은 도서</h2>
            <p class="tour-text-p">로그인을 통해</p>
            <p class="tour-text-p">독서기록을 남겨보세요</p>
        </div>
        <!-- 왼쪽에서 오른쪽으로 이동하는 책 이미지 배너 -->
        <div class="tour-banner-container">
            <ul class="left-banner-area">
                @forelse($data1 as $val)
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
            {{-- <ul class="left-banner-area"> --}}
            <ul class="left-banner-reverse-area">
                @forelse($data2 as $val)
                {{-- <li class="left-banner"> --}}
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
            <div class="left-banner-area">
                @forelse($data3 as $val)
                <div class="left-banner">
                    <img src="{{ $val->b_img_url }}" alt="...">
                </div>
                @empty
                    비어있음
                @endforelse
            </div>
        </div>       
    </section>

    {{-- 광고 영역3 --}}
    <section class="tour-section-3">
        <div class="tour-card-area">
            <div class="tour-card">
                <div class="content">
                    <h2 class="title">간편하지만, 꾸준한 효과!</h2>
                    <p class="copy">이동 중에도 책 한 권을 펼치면 당신은 언제 어디서나 새로운 세계를 열어볼 수 있어요.</p>
                </div>
            </div>
        
            <div class="tour-card">
                <div class="content">
                    <h2 class="title">지금, 시작하세요.</h2>
                    <p class="copy"> 작은 변화가 습관이 되고, 습관이 삶을 바꾸기 시작하면, 더 큰 성과를 얻을 수 있어요.</p>
                </div>
            </div>
        
            <div class="tour-card">
                <div class="content">
                    <h2 class="title">독서 후, 기록하세요.</h2>
                    <p class="copy">책을 읽은 후 그 감동과 생각을 적어주세요. 책의 내용에 대해 기억할 확률이 훨씬 높아져요.</p>
                </div>
            </div>
        
            <div class="tour-card">
                <div class="content">
                    <h2 class="title">독서, 건강해져요. </h2>
                    <p class="copy">바쁜 일상에서 느끼는 스트레스를 효과적으로 완화하고 싶다면, 독서가 최고의 친구에요.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- 영역4 주목할 만한 신간 영역 / 블로거 베스트셀러 영역 --}}
    <section class="tour-section-4">
        {{-- 주목할 만한 신간 영역 --}}
        <div class="tour-box1">
            <div class="tour-title">
                <strong>주목할 만한 신간</strong>
                <p>원하는 도서의 책을 골라보세요</p>
            </div>
            <ul class="tour-slide-container" id="slide">
                @forelse($result as $val)
                <li class="slide-box">
                    <a href="{{ route('getBookDetail', ['id' => $val->b_id]) }}">
                        <img src="{{$val->b_img_url}}" alt="...">
                    </a>
                        <p>{{$val->b_title}}</p>
                        <p>{{$val->b_author}}</p>
                </li>
                @empty
                    비어있음
                @endforelse
            </ul>
        </div>
        {{-- 블로거 베스트셀러 영역 --}}
        <div class="tour-box1">
            <div class="tour-title">
                <strong>블로거 베스트셀러</strong>
            </div>
            <ul class="tour-slide-container" id="slide2">
                @forelse($data as $val)
                <li class="slide-box">
                    <a href="{{ route('getBookDetail', ['id' => $val->b_id]) }}">
                        <img src="{{$val->b_img_url}}" alt="...">
                    </a>
                        <p>{{$val->b_title}}</p>
                        <p>{{$val->b_author}}</p>
                </li>
                @empty
                    비어있음
                @endforelse
            </ul>
        </div>
    </section>
</div>
@endsection

@section('defer-js')
    <script src="{{ asset('/js/common.js') }}" defer></script>
    <script src="{{ asset('/js/tour.js') }}" defer></script>
@endsection