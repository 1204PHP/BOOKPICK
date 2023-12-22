@extends('layout.layout')
{{-- layout.blade.php 상속 --}}
@section('title', '나의 서재')
{{-- title로 Main 표기 --}}
@section('content')
	<div class="library-grid">
		<div class="library-grid-left-box">
			<div class="library-content">
				<div class="library-title">
					<strong class="library-title-strong">지금까지 저장한 책이에요</strong>
					<span class="library-media"><br></span>
					<a href="{{ route('getLibraryFinished')}}" class="library-title-button">다 읽은 책</a>
					<a href="{{ route('getLibraryReading')}}" class="library-title-button">읽고 있는 책</a>
					<a href="{{ route('getLibraryWishlist')}}" class="library-title-button">찜한 책</a>
					<p class="library-title-p">
						총
						<span class="library-title_txt">10</span>
						권의 책이 있어요. 책을 눌러 감상을 기록해 보세요!
					</p>
				</div>
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
						<p>저장된 책이 없습니다.</p>
					@endforelse
				</div>
			</div>
		</div>
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