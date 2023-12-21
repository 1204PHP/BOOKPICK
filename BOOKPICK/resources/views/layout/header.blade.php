@php
// 현재 접속중인 라우트 이름
$currentRoute = Route::currentRouteName();
@endphp

@if(!in_array(Route::currentRouteName(), ['getLogin', 'getRegister', 'postLogin', 'postRegister']))
	<header>
		<div class="hamburger-menu">
		<div class="bar"></div>
		<div class="bar"></div>
		<div class="bar"></div>
		</div>
		<div class="navbar-logo">
			<a href="{{ route('home') }}">BOOK PICK'</a>
		</div>
		<nav class="desktop-nav">
			<a href="{{ route('getLibrary') }}" class="header-link {{ $currentRoute == 'library' ? 'active' : '' }}">나의 서재</a>
			<a href="{{ route('bookTour') }}" class="header-link {{ $currentRoute == 'bookTour' ? 'active' : '' }}">둘러보기</a>
			<div class="search-bar">
				<form class="desktop-search-bar" action="{{ route('getsearch.index') }}" method="GET">
					<input type="search" name="result" value="" placeholder="검색어를 입력해 주세요">
					<button type="submit">Search</button>
				</form>
			</div>
		</nav>
		@if(Auth::check())
				{{-- 로그인 후 표시될 내용 --}}
			<nav class="header-login-button">
				<a href="{{ route('getInfo') }}">회원정보 수정</a>
				<a href="{{ route('getLogout') }}">로그아웃</a>
			</nav>
		@else
			<nav class="header-login-button">
				<a href="{{ route('getLogin') }}">로그인</a>
			</nav>
		@endif
		<nav class="mobile-nav">			
			<div class="search-bar">
				<form class="desktop-search-bar" action="{{ route('getsearch.index') }}" method="GET">
					<input type="search" name="result" value="" placeholder="검색어를 입력해 주세요">
					<button type="submit">Search</button>
				</form>
			</div>				
			<a href="#">나의 서재</a></li>
			<a href="#">둘러보기</a></li>			
		</nav>
	</header>
@endif