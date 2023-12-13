@php
// 현재 접속중인 라우트 이름
$currentRoute = Route::currentRouteName();
@endphp

<nav class="fixed-top navbar navbar-dark bg-black navbar-expand-lg d-flex justify-content-end">
    <button id="btn-toggle" class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="sidebar">
        <div class="container-fluid">
            <div class="row">
                <div id="sidebar-layout" class="sidebar-layout scrollbar col-lg-2">
                    <div id="menu-icon">
                        <button type="button" class="sidebar-btn-close float-end mt-3" onclick="toggleMenuBtn()"><img src="{{ asset('img/sidebar-btn.png') }}"></button>
                    </div>
                    <a href="#" class="sidebar-layout-title sidebar-padding sidebar-text dp-block">BOOK PICK'</a>
                    @if(Auth::check())
                        {{-- 로그인 후 표시될 내용 --}}
                        {{-- TODO: 클릭이벤트 드롭다운 추가 --}}
                        <a href="#" class="sidebar-layout-login sidebar-padding sidebar-text dp-block">환영합니다 ㅇㅇㅇ씨</a>
                    @else
                        {{-- 로그인 전 표시될 내용 --}}
                        <a href="#" class="sidebar-layout-login sidebar-padding sidebar-text dp-block">로그인 후 이용하기</a>
                    @endif
                    <div class= "sidebar-layout-search">
                        <span class="sidebar-text dp-inline sidebar-padding">
                            <img src="{{ asset('img/category1-Search.png') }}">
                            도서 검색
                        </span>
                    </div>
                    <div class= "sidebar-layout-box">
                        <a href="{{ route('home') }}" class="sidebar-link {{ $currentRoute == 'home' ? 'active' : '' }} dp-inline sidebar-padding">
                            <img src="{{ asset('img/category2-Todays.png') }}">
                            오늘의 이슈
                        </a>
                    </div>
                    <div class= "sidebar-layout-box">
                        <a href="{{ route('cate') }}" class="sidebar-link {{ $currentRoute == 'cate' ? 'active' : '' }} dp-inline sidebar-padding">
                            <img src="{{ asset('img/category3-ByCategory.png') }}">
                            카테고리별 도서
                        </a>
                    </div>
                    <div class= "sidebar-layout-box">
                        <a href="{{ route('bestseller') }}" class="sidebar-link {{ $currentRoute == 'bestseller' ? 'active' : '' }} dp-inline sidebar-padding">
                            <img src="{{ asset('img/category4-BestSeller.png') }}">
                            베스트셀러
                        </a>
                    </div>
                    <div class= "sidebar-layout-box">
                        <a href="{{ route('recommend') }}" class="sidebar-link {{ $currentRoute == 'recommend' ? 'active' : '' }} dp-inline sidebar-padding">
                            <img src="{{ asset('img/category5-Recommend.png') }}">
                            북픽 추천 도서
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</nav>

