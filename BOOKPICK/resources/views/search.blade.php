@extends('layout.layout')
{{-- layout.blade.php 상속 --}}
@section('title', 'search')
{{-- title로 Main 표기 --}}
@section('content')
	{{-- @forelse($result as $key => $val)
	<span>{{$val}}</span>
	<br>
	@empty
	<span>정보가 없습니다.</span>
	@endforelse
	</div> --}}
	<div class="search_layout_div">
		<span class="search_div_span_txt">'{{$searchResult}}'</span>에 대한 {{$searchCnt}}개의 검색 결과
	</div>
	<div class="search_layout_container">
		@forelse($result as $val)
		<div class="search_layout_container_div">
			<img class="search_layout_container_img" src="{{$val->b_img_url}}">
			<p class="txt_p">{{$val->b_title}}</p>
			<p class="txt_p">{{$val->b_author}}</p>
			<p class="txt_p">{{$val->b_price}}</p>
		</div>
		@empty
			<p>검색어 결과가 없습니다.</p>
		@endforelse
	</div>
	@if(count($result) > 0)
	<div style="text-align: center;">
		@php
			// $currentUrl = url()->full();
			// $currentUrl = request()->getQueryString();
			$currentPage = $result->currentPage();
			$lastPage = $result->lastPage();
			$numToShow = 5; // 한 번에 표시할 페이지 번호의 개수
			$start = max(1, $currentPage - 2);
			$end = min($start + 4, $lastPage);
			$start = max(1, $end - 4);
		@endphp
		<a href="{{ $result->appends(request()->query())->url(1)}}">처음</a>
		@if ($currentPage > 1)
			<a href="{{ $result->appends(request()->query())->previousPageUrl() }}">이전</a>
		@endif
		@for($i = $start; $i <= $end; $i++)
			<a href="{{$result->appends(request()->query())->url($i)}}" @if($i == $currentPage)@endif>{{$i}}</a>
		@endfor
		@if ($currentPage < $lastPage )
			<a href="{{$result->appends(request()->query())->nextPageUrl()}}">다음</a>
		@endif
		<a href="{{$result->appends(request()->query())->url($lastPage)}}">맨끝</a>
	</div>
	@endif
	{{-- <div>
		@php
			// $currentUrl = url()->full();
			// $currentUrl = request()->getQueryString();
			$currentPage = $result->currentPage();
			$lastPage = $result->lastPage();
			$numToShow = 5; // 한 번에 표시할 페이지 번호의 개수
			$start = max(1, $currentPage - 2);
			$end = min($start + 4, $lastPage);
			$start = max(1, $end - 4);
		@endphp
		{{$ddddd}}
		<a href="{{ $result->url(1)}}">처음</a>{{$currentUrl}}
		@if ($currentPage > 1)
			<a href="{{ $result->previousPageUrl() }}">이전</a>
		@endif
		@for($i = $start; $i <= $end; $i++)
			<a href="{{$result->url($i)}}" @if($i == $currentPage)@endif>{{$i}}</a>
		@endfor
		@if ($currentPage < $lastPage )
			<a href="{{$result->nextPageUrl()}}">다음</a>
		@endif
		<a href="{{$result->url($lastPage)}}">맨끝</a>
	</div> --}}
@endsection