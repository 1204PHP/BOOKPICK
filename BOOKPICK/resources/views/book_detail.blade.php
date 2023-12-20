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
				<p class="book_datail_title_txt">{{$result->b_title}}</p>
				<br>
				<p class="book_datail_cate_txt">{{$result->b_main_cate}}</p>
				<br><br>
				<p class="book_datail_author_txt">{{$result->b_author}}</p>
				<br>
				<p class="book_datail_author_txt">{{$result->b_price}}</p>
				<br><br>
				<p>
					{{$result->b_summary}}
				</p>
			</div>
		</div>
	</div>
@endsection