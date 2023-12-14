@extends('layout.layout')
{{-- layout.blade.php 상속 --}}
@section('title', 'bestseller')
{{-- title로 Main 표기 --}}
@section('content')
	<div class="best-container">
		<h2 class="best-h2">주간 베스트</h2>
			<ul class="best-gird-box1">
				<li>
					<div class="img-best1"><img src="{{ asset('img/best1.jpg') }}" class="imgsize" alt="..."></div>
					<div><p class="best-p">
						시/에세이
						<br>
						<span class="best-content">내가 한 말을 내가 오해하지 않기로 함</span>
						<br>
						문상훈·위너스북</p></div>
					<div><p>가격: 13,500 원</p></div>
				</li>
				<li><div class="img-best1"><img src="{{ asset('img/best2.jpg') }}" class="imgsize" alt="..."></div></li>
				<li><div class="img-best1"><img src="{{ asset('img/best3.jpg') }}" class="imgsize" alt="..."></div></li>
				<li><div class="img-best1"><img src="{{ asset('img/best4.jpg') }}" class="imgsize" alt="..."></div></li>
				<li><div class="img-best1"><img src="{{ asset('img/best5.jpg') }}" class="imgsize" alt="..."></div></li>
				<li><div class="img-best1"><img src="{{ asset('img/best6.jpg') }}" class="imgsize" alt="..."></div></li>
				<li><div class="img-best1"><img src="{{ asset('img/best7.jpg') }}" class="imgsize" alt="..."></div></li>
				<li><div class="img-best1"><img src="{{ asset('img/best8.jpg') }}" class="imgsize" alt="..."></div></li>
				<li><div class="img-best1"><img src="{{ asset('img/best9.jpg') }}" class="imgsize" alt="..."></div></li>
				<li><div class="img-best1"><img src="{{ asset('img/best10.jpg') }}" class="imgsize" alt="..."></div></li>
			</ul>
			<button class="carousel-prev">이전</button>
			<button class="carousel-next">다음</button>
	</div>
	
	<div class="best-container2">
		<h2 class="best-h2">월간 베스트</h2>
			<ul class="best-gird-box1">
				<li>
					<div class="img-best1"><img src="{{ asset('img/best1.jpg') }}" class="imgsize" alt="..."></div>
					<div><p class="best-p">
						시/에세이
						<br>
						<span class="best-content">내가 한 말을 내가 오해하지 않기로 함</span>
						<br>
						문상훈·위너스북</p></div>
					<div><p>가격: 13,500 원</p></div>
				</li>
				<li><div class="img-best1"><img src="{{ asset('img/best2.jpg') }}" class="imgsize" alt="..."></div></li>
				<li><div class="img-best1"><img src="{{ asset('img/best3.jpg') }}" class="imgsize" alt="..."></div></li>
				<li><div class="img-best1"><img src="{{ asset('img/best4.jpg') }}" class="imgsize" alt="..."></div></li>
				<li><div class="img-best1"><img src="{{ asset('img/best5.jpg') }}" class="imgsize" alt="..."></div></li>
				<li><div class="img-best1"><img src="{{ asset('img/best6.jpg') }}" class="imgsize" alt="..."></div></li>
				<li><div class="img-best1"><img src="{{ asset('img/best7.jpg') }}" class="imgsize" alt="..."></div></li>
				<li><div class="img-best1"><img src="{{ asset('img/best8.jpg') }}" class="imgsize" alt="..."></div></li>
				<li><div class="img-best1"><img src="{{ asset('img/best9.jpg') }}" class="imgsize" alt="..."></div></li>
				<li><div class="img-best1"><img src="{{ asset('img/best10.jpg') }}" class="imgsize" alt="..."></div></li>
			</ul>
	</div>
@endsection