@extends('layout.layout')
{{-- layout.blade.php 상속 --}}
@section('title', '책상세 페이지')
{{-- title로 Main 표기 --}}
@section('content')
	{{-- <div class="book_detail_body">
		<div class="book_detail_container">
			<div class="book_detail_item">
				<img class="book_detail_img" src="{{$result->b_img_url}}" alt="">
			</div>
			<div class="book_detail_item">
				aa
			</div>

			<div class="book_detail_item">
				ss
			</div>
		</div>
	</div> --}}

	<div class="book_detail_layout">
		<div class="book_detail_layout1">
			<div class="book_detail_div1">
				<img class="book_detail_img" src="{{$result->b_img_url}}" alt="">
			</div>
			<div class="book_detail_div2">
				<br>
				<p class="book_datail_title_txt">{!!$result->b_title!!}</p>
				<br>
				<p class="book_datail_cate_txt">{{$result->b_main_cate}}</p>
				<br><br>
				<p class="book_datail_author_txt">{{$result->b_author}}</p>
				<br>
				<p class="book_datail_author_txt">{{$result->b_price}}</p>
				<br><br>
				<p>
					{!!$result->b_summary!!}
				</p>

				<input type="hidden" id="wishFlg" name="wishFlg" value="{{$wishFlg}}">
				<input type="hidden" id="libraryFlg" name="libraryFlg" value="{{$libraryFlg}}">
				@if(Auth::check())
					<!-- 로그인한 경우 -->
					<form action="{{ route('postBookDetailWishList') }}" method="POST">
						@csrf
						<button type="submit" onclick="BookDetailWishFlgshowAlert()">찜하기</button>
						<input type="hidden" id="b_id" name="b_id" value="{{$result->b_id}}">
					</form>
					<form action="{{ route('postBookDetailUserLibrary') }}" method="POST">
						@csrf
						<button type="submit" onclick="BookDetailLibraryFlgshowAlert()">
							@if($libraryFlg ===1)
								나의 서재 등록
							@endif
							@if($libraryFlg ===0)
								나의 서재 삭제
						@endif
					</button>
						@if($libraryFlg ===1)
							<input type="text" id="detailStartDate" name="detailStartDate" value="{{now()->format('Y-m-d')}}">
							<input type="text" id="detailEndDate" name="detailEndDate" value="{{now()->format('Y-m-d')}}">
						@endif
						<input type="hidden" id="library_b_id" name="library_b_id" value="{{$result->b_id}}">
					</form>
				@else
					<button type="button" onclick="BookDetailWishFlgshowAlert()">찜하기1</button>
					<button type="submit" onclick="BookDetailLibraryFlgshowAlert()">나의서재등록1</button>
				@endif

				{{-- @if(Auth::check())
				<!-- 로그인한 경우 -->
				<form action="{{ route('postBookDetailWishList') }}" method="POST">
					@csrf
					<button type="submit" onclick="BookDetailshowAlert()">찜하기</button>
					<input type="hidden" id="b_id" name="b_id" value="{{$result->b_id}}">
				</form>
				@else
					<button type="button" onclick="BookDetailshowAlert()">찜하기</button>
				@endif --}}
			</div>
		</div>
	</div>
@endsection