@php
// 현재 접속중인 라우트 이름
$currentRoute = Route::currentRouteName();
@endphp

<div class="sidebar">
	<a href="{{ route('home') }}" class="sidebar_logo">
        <span class="logo_bookpick">BOOK PICK'</span>
    </a>

	<div class="sidebar_submenu">
		@if(Auth::check())
			{{-- 로그인 후 표시될 내용 --}}
			{{-- TODO: 클릭이벤트 드롭다운 추가 --}}
			<a href="{{ route('getLogin') }}" class="sidebar_signin_area">
				<span class="login_txt">로그인 후 이용하기</span>
			</a>
		@else
			{{-- 로그인 전 표시될 내용 --}}
			<a href="{{ route('getLogin') }}" class="sidebar_signin_area">
				<span class="login_txt">로그인 후 이용하기</span>
			</a>
		@endif
		<div class="sidebar_member">
			<br>
			<a href="#" class="sidebar_button_area">
				<img class="member_icon" src="{{ asset('img/category1-Search.png') }}" />
				<span class="member_text">멤버십 구독</span>
			</a>
		</div>

		<div class="sidebar_search">
            <input type="search" class="search_input" placeholder="검색"/>
			<span class=icon_search></span>
        </div>

        <div class="sidebar_menu">
            <ul>
                <li>
					<a href="{{ route('home') }}" class="sidebar-link {{ $currentRoute == 'home' ? 'active' : '' }}">
						<img src="{{ asset('img/category2-Todays.png') }}" alt="" />
						<span>오늘의 이슈</span>
					</a>
				</li>
				<li>
					<a href="{{ route('cate') }}" class="sidebar-link {{ $currentRoute == 'cate' ? 'active' : '' }}">
						<img src="{{ asset('img/category3-ByCategory.png') }}" alt="" />
						<span>카테고리별 도서</span>
					</a>
				</li>
				<li>
					<a href="{{ route('bestseller') }}" class="sidebar-link {{ $currentRoute == 'bestseller' ? 'active' : '' }}">
						<img src="{{ asset('img/category4-BestSeller.png') }}" alt="" />
						<span>베스트셀러</span>
					</a>
				</li>
				<li>
					<a href="{{ route('recommend') }}" class="sidebar-link {{ $currentRoute == 'recommend' ? 'active' : '' }}">
						<img src="{{ asset('img/category5-Recommend.png') }}" alt="" />
						<span>북픽 추천 도서</span>
					</a>
				</li>
			</ul>
        </div>
	</div>
</div>