@extends('layout.layout')
{{-- layout.blade.php 상속 --}}
@section('title', '나의 서재')
{{-- title로 Main 표기 --}}
@section('content')
	<div class="library-grid">
		{{-- 왼쪽박스 --}}
		<div class="library-grid-left-box">
			<div class="library-content">
				{{-- 제목영역 --}}
				<div class="library-title">
					<strong class="library-title-strong">지금까지 저장한 책이에요</strong>
					<span class="library-media"><br></span>
						<a href="{{ route('getLibraryFinished') }}" class="library-title-button">다 읽은 책</a>
						<a href="{{ route('getLibraryReading') }}" class="library-title-button">읽고 있는 책</a>
						<a href="{{ route('getLibrarywishlist') }}" class="library-title-button">찜한 책</a>
					<p class="library-title-p">
						총
						<span class="library-title_txt">{{$resultCnt}}</span>
						권의 책이 있어요. 책을 눌러 감상을 기록해 보세요!
					</p>
				</div>
				<br>
				{{-- 책출력부분 --}}
				<div class="search_layout_container">
					@forelse($result as $val)
					<div class="search_layout_container_div">
						<a class="search_layout_container_a" href="{{ route('getBookDetail', ['id' => $val->b_id]) }}">
							<img class="search_layout_container_img" src="{{$val->b_img_url}}">
						</a>
						<p class="search_book_title_txt">
							<a href="{{ route('getBookDetail', ['id' => $val->b_id]) }}">{{$val->b_title}}</a>
						</p>
						<p class="search_book_author_txt">{{$val->b_author}}</p>
					</div>
					@empty
						<p class="library-no-layout"></p>
					@endforelse
				</div>
				{{-- 페이징부분 --}}
				@if($resultCnt > 0)
				<div class="paginate_div">
					@php
						$currentPage = $result->currentPage();
						$lastPage = $result->lastPage();
						$onFirstPage = $result->onFirstPage();
						$onLastPage = $result->onLastPage();
						$numToShow = 5; // 한 번에 표시할 페이지 번호의 개수
						$start = max(1, $currentPage - 2);
						$end = min($start + 4, $lastPage);
						$start = max(1, $end - 4);
					@endphp
					@if($currentPage == $onFirstPage)
						<a class="paginate_a paginate_disable" href="{{ $result->appends(request()->query())->url(1)}}"><<</a>
						<a class="paginate_prenext paginate_disable" href="{{ $result->appends(request()->query())->url(1)}}">이전</a>
					@else
						<a class="paginate_a" href="{{ $result->appends(request()->query())->url(1)}}"><<</a>
						<a class="paginate_prenext" href="{{ $result->appends(request()->query())->previousPageUrl() }}">이전</a>
					@endif
					@for($i = $start; $i <= $end; $i++)
						<a class="@if($i == $currentPage) paginate_current @else paginate_a @endif" href="{{$result->appends(request()->query())->url($i)}}" @if($i == $currentPage)@endif>{{$i}}</a>
					@endfor
					@if($currentPage == $onLastPage)
						<a class="paginate_prenext paginate_disable" href="{{$result->appends(request()->query())->url($lastPage)}}">다음</a>
						<a class="paginate_a paginate_disable" href="{{$result->appends(request()->query())->url($lastPage)}}">>></a>
					@else
						<a class="paginate_prenext" href="{{$result->appends(request()->query())->nextPageUrl()}}">다음</a>
						<a class="paginate_a" href="{{$result->appends(request()->query())->url($lastPage)}}">>></a>
					@endif
				</div>
			@endif
			</div>
		</div>
		{{-- 오른쪽박스 --}}
		<div class="library-grid-right-box">
			<div class="library-content">
				<div class="library-title">
					<strong class="library-title-strong">최근 기록한 메모</strong>
					<p class="library-title-p">
						메모를 클릭시 해당 책으로 이동합니다.
					</p>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('defer-js')
    <script src="{{ asset('/js/common.js') }}" defer></script>
@endsection