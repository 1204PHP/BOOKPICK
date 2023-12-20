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
            <ul class="slide-container">
                @forelse($result as $val)
                <li class="slide-box">
                        <img src="{{$val->b_img_url}}" alt="...">
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
            <img src="{{ asset('img/home-prev-btn.png') }}" class="prev" onclick="prev();" alt="...">
            <img src="{{ asset('img/home-next-btn.png') }}" class="next" onclick="next();" alt="...">
    </div>
    <div class="home-box2">
        <ul class="slide-container1">
            @forelse($result as $val)
            <li class="slide-box">
                    <img src="{{$val->b_img_url}}" alt="...">
                    <p>{{$val->b_title}}</p>
                    <p>{{$val->b_author}}</p>
            </li>
            @empty
                비어있음
            @endforelse
        </ul>
        <ul class="slide-container1-2">
            <li class="slide-box">독서왕</li>
        </ul>
    </div>
    <div class="home-box3">
        <ul class="slide-container">
            @forelse($result as $val)
            <li class="slide-box">
                    <img src="{{$val->b_img_url}}" alt="...">
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