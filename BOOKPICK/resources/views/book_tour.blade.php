@extends('layout.layout')
{{-- layout.blade.php 상속 --}}
@section('title', 'index')
{{-- title로 Main 표기 --}}
@section('content')
<div class="tour-container">    

    {{-- 광고 영역1 --}}
    <section class="tour-section-2">
        {{-- <div class="tour-text-area">
            <h2 class="tour-text-h2">당신을 위한 책들이 정리되어 있어요</h2>
            <p class="tour-text-p">지식의 물결을 따라 새로운 시야를 열어보세요</p>
        </div> --}}
        <!-- 왼쪽에서 오른쪽으로 이동하는 책 이미지 배너 -->
        <div class="tour-banner-container">
            <ul class="left-banner-area">
                @forelse($newBook as $val)
                <li class="left-banner">
                    <a href="{{ route('getBookDetail', $val['b_id']) }}">
                        <img src="{{ $val->b_img_url }}" alt="...">
                    </a>
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
                    <a href="{{ route('getBookDetail', $val['b_id']) }}">
                        <img src="{{$val->b_img_url}}" alt="...">
                    </a>
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
                    <a href="{{ route('getBookDetail', $val['b_id']) }}">
                        <img src="{{ $val->b_img_url }}" alt="...">
                    </a>
                </li>
                @empty
                    비어있음
                @endforelse
            </ul>
        </div>       
    </section>

    
    {{-- 광고 영역2 --}}
    {{-- <section class="tour-section-5">
        <div class="tour-text-area">
            <h2 class="tour-text-h2">나만의 생각, 지금 공유하세요</h2>
            <p class="tour-text-p">책에 대한 다양한 생각을 함께 나눠보세요</p>
        </div>
        <div class="tour-memo-container">
            <strong>가장 뜨거운 인기게시물!! TOP 3</strong>
            <p>당신의 생각은 어떤가요?</p>
            <div class="book-detail-memo-container">
                @forelse($bookCommentTop3 as $val)
                <a href="{{ route('getBookDetail', ['id' => $val['b_id']]) }}">
                    <div class="book-detail-memo-area memo1">
                        <p>{{ $val['b_title'] }}</p>
                        <span>{{ $val['u_email'] }}</span>
                        <span>{{ $val['bdc_comment'] }}</span>
                    </div>
                </a>
                @empty
                <p>내용없음</p>
                @endforelse
            </div>
        </div>
    </section> --}}

    {{-- 광고 영역3 --}}
    <section class="tour-section-4">
        <div class="tour-text-area">
            <h2 class="tour-text-h2">망설이는 당신을 위해, 이 책 어때요?</h2>
            <p class="tour-text-p">선택의 어려움을 덜어줄 다양한 추천 도서를 만나보세요</p>
        </div>
        {{-- 캐러셀 --}}
        <div class="slide-container-1">
            <div class="slide-content">
                <img src="{{ asset('img/ad-1.png') }}" alt="...">
            </div>
            <div class="slide-content">
                <img src="{{ asset('img/ad-2.png') }}" alt="...">
            </div>
            <div class="slide-content">
                <img src="{{ asset('img/ad-3.png') }}" alt="...">
            </div>
            <div class="slide-content">
                <img src="{{ asset('img/ad-4.png') }}" alt="...">
            </div>
            <div class="slide-content">
                <img src="{{ asset('img/ad-5.png') }}" alt="...">
            </div>
            <div class="slide-content">
                <img src="{{ asset('img/ad-6.png') }}" alt="...">
            </div>
            <div class="slide-content">
                <img src="{{ asset('img/ad-7.png') }}" alt="...">
            </div>
            <div class="slide-content">
                <img src="{{ asset('img/ad-8.png') }}" alt="...">
            </div>
            <div class="slide-content">
                <img src="{{ asset('img/ad-9.png') }}" alt="...">
            </div>
            <div class="slide-content">
                <img src="{{ asset('img/ad-10.png') }}" alt="...">
            </div>
            <a class="prev" onclick="plusSlide(-1)">&#10094</a>
            <a class="next" onclick="plusSlide(1)">&#10095</a>
            <div id="pagination">
                <div class="ball" onclick="currentSlide(1)"></div>
                <div class="ball" onclick="currentSlide(2)"></div>
                <div class="ball" onclick="currentSlide(3)"></div>
                <div class="ball" onclick="currentSlide(4)"></div>
                <div class="ball" onclick="currentSlide(5)"></div>
                <div class="ball" onclick="currentSlide(6)"></div>
                <div class="ball" onclick="currentSlide(7)"></div>
                <div class="ball" onclick="currentSlide(8)"></div>
                <div class="ball" onclick="currentSlide(9)"></div>
                <div class="ball" onclick="currentSlide(10)"></div>
            </div>
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
    
    {{-- 광고 영역4 --}}
    <section class="tour-section-3">
        <div class="tour-text-area">
            <h2 class="tour-text-h2">북픽과 함께하는 새로운 시작</h2>
            <p class="tour-text-p">성공을 향한 여정, 독서와 함께 떠나보세요</p>
        </div>
        <div class="tour-card-area">
            <div class="tour-card" id="tour-card-1">
                <div class="content">
                    <h2 class="title">쉽지만, 꾸준한 효과!</h2>
                    <p class="copy">이동 중에도 책을 펼치면 언제 어디서나<br>
                        새로운 세계를 열어볼 수 있어요.</p>
                </div>
            </div>
            {{-- 1 카드 모달 --}}
            <div class="tour-modal" id="tour-modal-1">
                <div class="tour-modal-content">
                    <img src="{{ asset('img/tour-c1.png') }}" alt="">
                    <span class="tour-modal-close">&times;</span>
                </div>
            </div>
        
            <div class="tour-card" id="tour-card-2">
                <div class="content">
                    <h2 class="title">지금, 독서하세요.</h2>
                    <p class="copy"> 작은 변화가 습관이 되고,<br>
                        습관이 삶을 바꾸기 시작하면,<br>
                        더 큰 성과를 얻을 수 있어요.</p>
                </div>
            </div>
            {{-- 2 카드 모달 --}}
            <div class="tour-modal" id="tour-modal-2">
                <div class="tour-modal-content">
                    <img src="{{ asset('img/tour-c2.png') }}" alt="">
                </div>
                <span class="tour-modal-close">&times;</span>
            </div>
        
            <div class="tour-card" id="tour-card-3">
                <div class="content">
                    <h2 class="title">독서 후, 기록하세요.</h2>
                    <p class="copy">책을 읽고, 그 감동과 생각을 적어주세요.<br>
                        책의 내용에 대해 기억할 확률이<br>
                        훨씬 높아져요.</p>
                </div>
            </div>
            {{-- 3 카드 모달 --}}
            <div class="tour-modal" id="tour-modal-3">
                <div class="tour-modal-content">
                    <img src="{{ asset('img/tour-c3.png') }}" alt="">
                    <span class="tour-modal-close">&times;</span>
                </div>
            </div>
            <a href="{{ route('getLogin') }}">
                <div class="tour-card" id="tour-card-4">
                    <div class="content">
                        <h2 class="title">지금, 북픽하세요.</h2>
                        <p class="copy">로그인하기
                    </div>
                </div>
            </a>           
        </div>
    </section>
</div>
@endsection

@section('defer-js')
    <script src="{{ asset('/js/common.js') }}" defer></script>
    <script src="{{ asset('/js/tour.js') }}" defer></script>
@endsection