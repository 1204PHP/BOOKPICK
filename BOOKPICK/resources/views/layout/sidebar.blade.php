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
                    <a href="#" class="sidebar-layout-login sidebar-padding sidebar-text dp-block">로그인 후 이용하기</a>
                    <div class= "sidebar-layout-search">
                        <span class="sidebar-text dp-inline sidebar-padding">
                            <img src="{{ asset('img/category1-Search.png') }}">
                            도서 검색
                        </span>
                    </div>
                    <div class= "sidebar-layout-box">
                        <a href="#" class="sidebar-text dp-inline sidebar-padding">
                            <img src="{{ asset('img/category2-Todays.png') }}">
                            오늘의 이슈
                        </a>
                    </div>
                    <div class= "sidebar-layout-box">
                        <a href="#" class="sidebar-text dp-inline sidebar-padding">
                            <img src="{{ asset('img/category3-ByCategory.png') }}">
                            카테고리별 도서
                        </a>
                    </div>
                    <div class= "sidebar-layout-box">
                        <a href="#" class="sidebar-text dp-inline sidebar-padding">
                            <img src="{{ asset('img/category4-BestSeller.png') }}">
                            베스트셀러
                        </a>
                    </div>
                    <div class= "sidebar-layout-box">
                        <a href="#" class="sidebar-text dp-inline sidebar-padding">
                            <img src="{{ asset('img/category5-Recommend.png') }}">
                            북픽 추천 도서
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</nav>

