@extends('layout.layout')
{{-- layout.blade.php 상속 --}}
@section('title', 'home')
{{-- title로 Main 표기 --}}
@section('content')
<div class="home-container">
    <div class="home-main">
        {{-- <div class="home-baaner">
            <div class="Hbaaner">
                <img src="{{ asset('img/home-book1.png') }}" class="Hbaaner1" alt="...">
            </div>
            <div class="Hbaaner">
                <img src="{{ asset('img/home-book2.png') }}" class="Hbaaner1" alt="...">
            </div>
            <div class="Hbaaner">
                <img src="{{ asset('img/home-book3.png') }}" class="Hbaaner1" alt="...">
            </div>
        </div> --}}
        <div class="home-baaner">
            <img src="{{ asset('img/home-book1.png') }}" class="Hbaaner" alt="...">
            <img src="{{ asset('img/home-book2.png') }}" class="Hbaaner" alt="...">
            <img src="{{ asset('img/home-book3.png') }}" class="Hbaaner" alt="...">
        </div>
        <div class="home-box">
            <div class="indicator active" onclick="currentSlide(1)"></div>
            <div class="indicator" onclick="currentSlide(2)"></div>
            <div class="indicator" onclick="currentSlide(3)"></div>
        </div>
    </div>
    <div class="home-box1">
        <div class="home-title">
            <strong>베스트셀러</strong>
            <p>베스트셀러를 알려 드려요!</p>
        </div>
            <ul class="slide-container" id="slide">
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
                {{-- <li class="slide-box"><img src="{{$result[0]->b_img_url}}" alt="..."></li>
                <li class="slide-box"><img src="{{$result[1]->b_img_url}}" alt="..."></li>
                <li class="slide-box"><img src="{{ asset('img/best3.jpg') }}" alt="..."></li>
                <li class="slide-box"><img src="{{ asset('img/best1.jpg') }}" alt="..."></li>
                <li class="slide-box"><img src="{{ asset('img/best1.jpg') }}" alt="..."></li>
                <li class="slide-box"><img src="{{ asset('img/best1.jpg') }}" alt="..."></li> --}}
            </ul>
            {{-- 버튼 없이 하기로 했음 --}}
            {{-- <img src="{{ asset('img/home-prev-btn.png') }}" class="prev" onclick="prev();" alt="...">
            <img src="{{ asset('img/home-next-btn.png') }}" class="next" onclick="next();" alt="..."> --}}
    </div>
    <div class="home-recommend">
        <strong>북픽 추천 도서</strong>
    </div>
    <div class="home-box2">
        <ul class="slide-container2" id="slide3">
            @forelse($rand as $val2)
            <li class="slide-box">
                <a href="{{ route('getBookDetail', ['id' => $val2->b_id]) }}">
                    <img src="{{$val2->b_img_url}}" alt="...">
                </a>    
                    <p>{{$val2->b_title}}</p>
                    <p>{{$val2->b_author}}</p>
            </li>
            @empty
                비어있음
            @endforelse
        </ul>
        <ul class="slide-container2-2" id="slide1">
            <li class="bookworm">
                <strong>인기 도서 찜 순위!!</strong>
                <br>
                <p>북픽회원이 가장 많이 찜한 책 TOP 5</p>
            </li>
            <li class="home-booking">1. 역행자 확장판 (50만 부 기념 유니버스 에디션) - 돈·시간·운명으로부터 완전한 자유를 얻는 7단계 인생 공략집</li>
            <li class="home-booking">2. 사피엔스 - 유인원에서 사이보그까지, 인간 역사의 대담하고 위대한 질문</li>
            <li class="home-booking">3. 여중기님 <span class="home-booking-span">읽은책5권</span></li>
            <li class="home-booking">4. 김지웅님 <span class="home-booking-span">읽은책4권</span></li>
            <li class="home-booking">5. 양주은님 <span class="home-booking-span">읽은책2권</span></li>
        </ul>
    </div>
    <div class="home-box3">
        <div class="home-title">
            <strong>신간 도서 추천</strong>
            <p>따뜻한 신간 도서를 만나보세요</p>
        </div>
        <ul class="slide-container" id="slide2">
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
</div>
@endsection

@section('defer-js')
    <script src="{{ asset('/js/common.js') }}" defer></script>
    <script src="{{ asset('/js/home.js') }}" defer></script>
@endsection