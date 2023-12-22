@extends('layout.layout')
{{-- layout.blade.php 상속 --}}
@section('title', 'home')
{{-- title로 Main 표기 --}}
@section('content')
<div class="tour-container">
	<div class="tour-main">
		<div class="tour-baaner">
            <img src="{{ asset('img/tour2.png') }}" class="Tbaaner" alt="...">
        </div>
	</div>
	<div class="tour-main">
		<div class="tour-baaner">
            {{-- 2번 광고배너 --}}
            {{-- <img src="{{ asset('img/tour10.png') }}" class="Tbaaner" alt="..."> --}}
        </div>
	</div>
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
	<div class="tour-box1">
        <div class="tour-title">
            <strong>국내 도서 베스트셀러</strong>
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
</div>
@endsection

@section('defer-js')
    <script src="{{ asset('/js/common.js') }}" defer></script>
    <script src="{{ asset('/js/tour.js') }}" defer></script>
@endsection