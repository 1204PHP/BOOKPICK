@extends('layout.layout')
{{-- layout.blade.php 상속 --}}
@section('title', '검색 페이지')
{{-- title로 Main 표기 --}}
@section('content')
	{{-- 검색텍스트 부분 --}}
	<div class="search_layout_div">
		<div class="search_layout_div_div">
			<p class="search_div_div_p">'</p>
			<p class="search_div_div_txt">{{$searchResult}}</p>
			<p class="search_div_div_p">'</p>
		</div>
		<p class="search_div_div_p">에 대한 {{$algoliaCnt}}개의 검색 결과</p>
	</div>

	{{-- 도서 부분 --}}
	<div class="search_layout_container">
		@forelse($algoliaResult as $book)
		{{-- <p>{{$book['b_img_url']}}</p> --}}
		<div class="search_layout_container_div">
			<a class="search_layout_container_a" href="{{ route('getBookDetail', $book['b_id']) }}">
				<img class="search_layout_container_img" src="{{$book['b_img_url']}}">
			</a>
			<p class="search_book_title_txt">
				<a href="{{ route('getBookDetail', $book['b_id']) }}">{{$book['b_title']}}</a>
			</p>
			<p class="search_book_author_txt">{{$book['b_author']}}</p>
		</div>
		@empty
			<p class="search_book_nosearch_txt">검색어 결과가 없습니다.</p>
		@endforelse
	</div>

	{{-- 페이징 부분 --}}
	@if($algoliaCnt > 0)
		<div class="paginate_div">
			@php
				$currentPage = $algoliaResult->currentPage();
				$lastPage = $algoliaResult->lastPage();
				$onFirstPage = $algoliaResult->onFirstPage();
				$onLastPage = $algoliaResult->onLastPage();
				$numToShow = 5; // 한 번에 표시할 페이지 번호의 개수
				$start = max(1, $currentPage - 2);
				$end = min($start + 4, $lastPage);
				$start = max(1, $end - 4);
			@endphp
			@if($currentPage == $onFirstPage)
				<a class="paginate_a paginate_disable" href="{{ $algoliaResult->appends(request()->query())->url(1)}}"><<</a>
				<a class="paginate_prenext paginate_disable" href="{{ $algoliaResult->appends(request()->query())->url(1)}}">이전</a>
			@else
				<a class="paginate_a" href="{{ $algoliaResult->appends(request()->query())->url(1)}}"><<</a>
				<a class="paginate_prenext" href="{{ $algoliaResult->appends(request()->query())->previousPageUrl() }}">이전</a>
			@endif
			@for($i = $start; $i <= $end; $i++)
				<a class="@if($i == $currentPage) paginate_current @else paginate_a @endif" href="{{$algoliaResult->appends(request()->query())->url($i)}}" @if($i == $currentPage)@endif>{{$i}}</a>
			@endfor
			@if($currentPage == $onLastPage)
				<a class="paginate_prenext paginate_disable" href="{{$algoliaResult->appends(request()->query())->url($lastPage)}}">다음</a>
				<a class="paginate_a paginate_disable" href="{{$algoliaResult->appends(request()->query())->url($lastPage)}}">>></a>
			@else
				<a class="paginate_prenext" href="{{$algoliaResult->appends(request()->query())->nextPageUrl()}}">다음</a>
				<a class="paginate_a" href="{{$algoliaResult->appends(request()->query())->url($lastPage)}}">>></a>
			@endif
		</div>
	@endif
@endsection

@section('defer-js')
    <script src="{{ asset('/js/common.js') }}" defer></script>
@endsection

@section('footer')
        
    <footer class="user-footer">
        <div class="footer-container">
            <div class="footer-section-left">
                <div class="footer-logo">
                    <a href="{{ route('index') }}">BOOK PICK'</a>
                </div><br>
                <p class="footer-text">제작자 : 오성찬, 여중기, 신호철</p>
                <p class="footer-text">그린컴퓨터아트학원 | 대구광역시 중구 중앙대로 394 제일빌딩 5F</p>
                <p class="footer-text">평일 09:00 ~ 22:30 | 토요일 09:00 ~ 18:30 | 대표전화 : 053.572.1005</p>
                <p class="footer-copytext">&copy; 2023~2024 BOOKPICK' Corp. All rights reserved.</p>
            </div>
            <div class="footer-section-right">
                <p class="footer-copytext-right">&copy; 2023~2024 BOOKPICK' Corp. All rights reserved.</p>
                <div class="footer-sns">
                    <a href=""><img src="https://api.iconify.design/entypo-social/youtube-with-circle.svg?color=%23666" alt=""></a>
                    <a href=""><img src="https://api.iconify.design/entypo-social/instagram-with-circle.svg?color=%23666" alt=""></a>
                    <a href=""><img src="https://api.iconify.design/entypo-social/facebook-with-circle.svg?color=%23666" alt=""></a>
                    <a href=""><img src="https://api.iconify.design/ant-design/twitter-circle-filled.svg?color=%23666" alt=""></a>
                </div>
                <div class="footer-app">
                    <a href=""><img src="https://www.koreanair.com/content/dam/koreanair/ko/main/banner-googleplay.svg" alt=""></a>
                    <a href=""><img src="https://www.koreanair.com/content/dam/koreanair/ko/main/banner-appstore.svg" alt=""></a>
                </div>
            </div>
        </div>
    </footer>
@endsection