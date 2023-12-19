@php
// 현재 접속중인 라우트 이름
$currentRoute = Route::currentRouteName();
@endphp

@if(!in_array(Route::currentRouteName(), ['getLogin', 'getRegister', 'postLogin', 'postRegister']))
<nav class="navbar">
	<div class="navbar__logo">
		<a href="{{ route('home') }}" class="logo_txt">BOOK PICK'</a>
	</div>

	<ul class="navbar__menu">
		<li><a href="{{ route('getLibrary') }}" class="header-link {{ $currentRoute == 'library' ? 'active' : '' }}">나의 서재</a></li>
		<li><a href="{{ route('bookTour') }}" class="header-link {{ $currentRoute == 'bookTour' ? 'active' : '' }}">둘러보기</a></li>
	</ul>
	<div class="header_search">
		<form action="{{ route('getsearch.index') }}" method="get">
			<input type="search" name="result" value="" class="header_input" placeholder="검색어를 입력해 주세요"/>
			<button type="submit">Search</button>
		</form>
	</div>
	<div class="header_signin">
		@if(Auth::check())
			{{-- 로그인 후 표시될 내용 --}}
			<a href="{{ route('getInfo') }}" class="header_signin_area">
				<span class="signin_txt">id</span>
			</a>
			<a href="{{ route('getLogout') }}" class="header_signin_area">
				로그아웃
			</a>
		@else
			{{-- 로그인 전 표시될 내용 --}}
			<a href="{{ route('getLogin') }}" class="header_signin_area">
				로그인
			</a>

		@endif
	</div>

	<button class="navbar__toggleBtn">
        <i>메뉴</i>
    </button>
	<button class="navbar__toggleBtn1">
        <i>검색</i>
    </button>
</nav>
@endif