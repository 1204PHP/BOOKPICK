@extends('layout.layout')
{{-- layout.blade.php 상속 --}}
@section('title', 'home')
{{-- title로 Main 표기 --}}
@section('content')
<div class="home-container">
    <div class="home-baaner">
        <img src="{{ asset('img/home.1.png') }}" class="Hbaaner" alt="...">
        <img src="{{ asset('img/home.2.png') }}" class="Hbaaner" alt="...">
        <img src="{{ asset('img/home.3.png') }}" class="Hbaaner" alt="...">
    </div>
	<div class="home-box">
        <div class="indicator" onclick="currentSlide(1)"></div>
        <div class="indicator" onclick="currentSlide(2)"></div>
        <div class="indicator" onclick="currentSlide(3)"></div>
    </div>
    <div class="home-box">
        <div class="indicator active" onclick="currentSlide(1)"></div>
        <div class="indicator" onclick="currentSlide(2)"></div>
        <div class="indicator" onclick="currentSlide(3)"></div>
    </div>
    <div class="home-box1">베스트셀러</div>
    <div class="home-box2">유저안목</div>
    <div class="home-box3">북픽추천</div>
</div>
@endsection