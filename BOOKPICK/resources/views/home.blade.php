@extends('layout.layout')
{{-- layout.blade.php 상속 --}}
@section('title', 'home')
{{-- title로 Main 표기 --}}
@section('content')
	<div class="home-container">
		<div class="home-baaner">광고</div>
		<div class="home-box1">베스트셀러</div>
		<div class="home-box2">유저안목</div>
		<div class="home-box3">북픽추천</div>
	</div>
@endsection