@extends('layout.layout')
{{-- layout.blade.php 상속 --}}
@section('title', 'home')
{{-- title로 Main 표기 --}}
@section('content')
	<div id="carouselExampleCaptions" class="carousel slide home-carousel-div" data-bs-ride="carousel">
		<div class="carousel-inner">
			<div class="carousel-item active">
				<img src="{{ asset('img/home-book1.png') }}" class="d-block w-100 home-layout" alt="...">
			</div>
			<div class="carousel-item">
				<img src="{{ asset('img/home-book2.png') }}" class="d-block w-100 home-layout" alt="...">
			</div>
			<div class="carousel-item">
				<img src="{{ asset('img/home-book3.png') }}" class="d-block w-100 home-layout" alt="...">
			</div>
		</div>
		{{-- <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
			<span class="carousel-control-prev-icon" aria-hidden="true"></span>
			<span class="visually-hidden">Previous</span>
		</button>
		<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
			<span class="carousel-control-next-icon" aria-hidden="true"></span>
			<span class="visually-hidden">Next</span>
		</button> --}}
		<div class="carousel-indicators">
			<button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
			<button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
			<button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
		</div>
	</div>
	<div class="home-title">
	</div>
	<div class="home-layout">
	</div>
@endsection