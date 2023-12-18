<nav class="navbar">
	<div class="navbar__logo">
		<a href="" class="logo_txt">BOOK PICK'</a>
	</div>

	<ul class="navbar__menu">
		<li><a href="#">나의 서재</a></li>
		<li><a href="#">둘러보기</a></li>
	</ul>
	<div class="header_search">
		<input type="search" class="header_input" placeholder="검색어를 입력해 주세요"/>
		<span class=icon_search></span>
	</div>
	<div class="header_signin">
		@if(Auth::check())
			{{-- 로그인 후 표시될 내용 --}}
			{{-- TODO: 클릭이벤트 드롭다운 추가 --}}
			<a href="{{ route('getLogin') }}" class="header_signin_area">
				<span class="signin_txt">로그인 후 이용하기</span>
			</a>
		@else
			{{-- 로그인 전 표시될 내용 --}}
			<a href="{{ route('getLogin') }}" class="header_signin_area">
				로그인
			</a>
			<a href="{{ route('getLogin') }}" class="header_signin_area">
				회원가입
			</a>
		@endif
	</div>

	<a href="#" class="navbar__toggleBtn">
        <i>메뉴</i>
    </a>
	<a href="#" class="navbar__toggleBtn1">
        <i>검색</i>
    </a>
    </nav>
</nav>