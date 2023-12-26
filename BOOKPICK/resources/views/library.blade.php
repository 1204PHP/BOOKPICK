@extends('layout.layout')
{{-- layout.blade.php 상속 --}}
@section('title', '나의 서재')
{{-- title로 Main 표기 --}}
@section('content')
	@php
		// 현재 접속중인 라우트 이름
		$currentRoute = Route::currentRouteName();
	@endphp
	<div class="library-grid">
		{{-- 왼쪽박스 --}}
		<div class="library-grid-left-box">
			<div class="library-content">
				{{-- 제목영역 --}}
				<div class="library-title">
					<strong class="library-title-strong">지금까지 저장한 책이에요</strong>
					<span class="library-media"><br></span>
					<a href="{{ route('getLibrarywishlist') }}" class="library-title-button {{ $currentRoute == 'getLibrarywishlist' ? 'active' : '' }}">찜한 책</a>
						<a href="{{ route('getLibraryFinished') }}" class="library-title-button {{ $currentRoute == 'getLibraryFinished' ? 'active' : '' }}">다 읽은 책</a>
						<a href="{{ route('getLibraryReading') }}" class="library-title-button {{ $currentRoute == 'getLibraryReading' ? 'active' : '' }}">읽고 있는 책</a>
					<p class="library-title-p">
						총
						<span class="library-title_txt">{{$resultCnt}}</span>
						권의 책이 있어요. 책을 눌러 감상을 기록해 보세요!
					</p>
				</div>
				<br>
				{{-- 책출력부분 --}}
				<div class="library_layout_container @if($result->isEmpty()) library-empty-style @endif">
					@forelse($result as $val)
					<div class="library_layout_container_div">
						<a class="library_layout_container_a" href="{{ route('getBookDetail', ['id' => $val->b_id]) }}">
							<img class="search_layout_container_img" src="{{$val->b_img_url}}">
						</a>
						<p class="library_book_title_txt">
							<a href="{{ route('getBookDetail', ['id' => $val->b_id]) }}">{{$val->b_title}}</a>
						</p>
						<p class="library_book_author_txt">{{$val->b_author}}</p>
					</div>
					@empty
						<div class="library-no-layout2">현재 저장 목록이 비어있습니다.</div>
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
				<br>
				<div class="library-no-layout"></div>
			</div>
		</div>
	</div>
	<div class="library-top">
		<div class="library-top1">
			<div class="library-content">
				<div class="library-title">
					<strong class="library-title-strong">많이 읽은 장르</strong>
					<p class="library-title-p">다 읽은책, 읽고 있는 책 기준</p>
				</div>
				<div class="library-no-layout1">
					
				</div>
			</div>
		</div>
		<div class="library-top2">
			<div class="library-content">
				<div class="library-title">
					<strong class="library-title-strong">이달의 기록 현황</strong>
					<p class="library-title-p">지난달보다 기록활동이 2회 증가했어요!</p>
				</div>
				<div class="library-no-layout1">
					{{-- 임시 --}}
				</div>
			</div>
		</div>
	</div>
@endsection

@section('defer-js')
    <script src="{{ asset('/js/common.js') }}" defer></script>
@endsection