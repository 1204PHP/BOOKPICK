@php
// 현재 접속중인 라우트 이름
$currentRoute = Route::currentRouteName();
@endphp

@if(!in_array(Route::currentRouteName(), ['getLogin', 'getRegister', 'postLogin', 'postRegister']))
	<header>
		<div class="hamburger-menu" onclick="addEventListener()">
		<div class="bar"></div>
		<div class="bar"></div>
		<div class="bar"></div>
		</div>
		<div class="navbar-logo">
			<a href="{{ route('index') }}">BOOK PICK'</a>
		</div>
		<nav class="desktop-nav">
			<a href="{{ route('getLibraryFinished') }}" class="header-link {{ in_array($currentRoute, ['getLibraryFinished', 'getLibraryReading', 'getLibrarywishlist']) ? 'active' : '' }}">나의 서재</a>
			<a href="{{ route('bookTour') }}" class="header-link {{ $currentRoute == 'bookTour' ? 'active' : '' }}">둘러보기</a>
			<div class="search-bar">
				<form class="desktop-search-bar" action="{{ route('getsearch.index') }}" method="GET">
					<input type="search" name="result" value="" placeholder="검색어를 입력해 주세요">
					<button class="header-search-btn" type="submit">검색</button>
				</form>
			</div>
		</nav>
		@auth
			{{-- 로그인 후 표시될 내용 --}}
			<div class="header-user-area">
				<div class="header-login-button-area">
					<nav class="header-info-button">
						<a class="header-info-btn" href="{{ route('getPasswordReconfirm') }}">{{ Auth::user()->u_name }} 님</a>
						<button class="header-logout-btn" onclick="location.href='{{ route('getLogout') }}'">로그아웃</button>
					</nav>
				</div>
			</div>
		@else
			<div class="header-login-button-area">
					<button class="header-login-btn" onclick="location.href='{{ route('getLogin') }}'">로그인</button>
			</div>
		@endauth
		<nav class="mobile-nav">			
			<div class="phone-search-bar">
				<form class="desktop-search-bar" action="{{ route('getsearch.index') }}" method="GET">
					<input type="search" name="result" value="" placeholder="검색어를 입력해 주세요">
					<button class="header-search-btn" type="submit">검색</button>
				</form>
			</div>				
			<a href="{{ route('getLibraryFinished') }}">나의 서재</a></li>
			<a href="{{ route('bookTour') }}">둘러보기</a></li>				
		</nav>
	</header>
@endif

