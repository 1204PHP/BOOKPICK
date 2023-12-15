@extends('layout.layout')
{{-- layout.blade.php 상속 --}}
@section('title', 'home')
{{-- title로 Main 표기 --}}
@section('content')
	<div class="carousel-container">
		<div class="carousel-wrapper" id="carouselWrapper">
			<div class="carousel-item">1</div>
			<div class="carousel-item">2</div>
			<div class="carousel-item">3</div>
			<!-- 추가적인 캐러셀 아이템들 -->
		</div>
	</div>
@endsection