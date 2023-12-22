@extends('layout.layout')
{{-- layout.blade.php 상속 --}}
@section('title', '책상세 페이지')
{{-- title로 Main 표기 --}}
@section('content')
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
				
				<br>
				<br>
				@if(Auth::check())
					<!-- 로그인한 경우 -->
					<form class="book_datail_form1" action="{{ route('postBookDetailWishList') }}" method="POST">
						@csrf
						<button type="submit" onclick="BookDetailWishFlgshowAlert()">찜하기</button>
						<input type="hidden" id="b_id" name="b_id" value="{{$result->b_id}}">
					</form>

					<form class="book_datail_form2" action="{{ route('postBookDetailUserLibrary') }}" onsubmit="BookDetailLibraryFlgshowAlert(event)" name="validateForm" method="POST">
						@csrf
						<input type="hidden" id="library_b_id" name="library_b_id" value="{{$result->b_id}}">
						
						@if($libraryFlg ===1)
								<button type="button" onclick="BookDetailopenModal()">
									내 서재에 추가
								</button>
								<br>
								<div id="myModal" class="modal">
									<div class="modal-content">
										<input type="date" id="detailStartDate" name="detailStartDate">
										<span >에서</span>
										<span class="modal-content-br"><br></span>
										<input type="date" id="detailEndDate" name="detailEndDate">
										<span >까지</span>
										<br>
										<button class="modal-content-submit"type="submit">등록</button>
									</div>
								</div>
						@endif

						@if($libraryFlg ===0)
							<button type="submit">
							서재에서 삭제
							</button>
						@endif
					</form>
				@else
					<button type="button" onclick="BookDetailWishFlgshowAlert()">찜하기1</button>
					<button type="submit" onclick="BookDetailLibraryFlgshowAlert()">나의서재등록1</button>
				@endif
			</div>
		</div>
	</div>
		{{--연관 책 추천 여역  --}}
	<div class="book_detail_box1">
        <div class="book_detail_title">
            <strong>검색 연관 도서</strong>
            <p>이런 도서는 어떠세요?</p>
        </div>
        <ul class="book_detail_slide_container" id="slide">
            @forelse($result as $val)
            <li class="book_detail_slide-box">
				<img src="..." alt="...">
				{{-- <img src="{{ asset('img/best1.jpg') }}" alt="..."> --}}
                <p></p>
                <p></p>
            </li>
            @empty
                비어있음
            @endforelse
        </ul>
    </div>
		{{--댓글 작성 영역  --}}
	<div class="book_detail_comment_layout">
		<div class="book_detail_comment_section-box">
			<div class="book_detail_comment_section-1">
				<strong>독자들의 코멘트</strong>
				<button>코멘트 작성</button>
			</div>
			<div class="book_detail_comment_grid">
				<div class="book_detail_comment_grid-item">호철</div>
				<div class="book_detail_comment_grid-item">중기</div>
				<div class="book_detail_comment_grid-item">중중기</div>
				<div class="book_detail_comment_grid-item">중중중기</div>
				<div class="book_detail_comment_grid-item">중중중중기</div>
				<div class="book_detail_comment_grid-item">중중중중기</div>
				<div class="book_detail_comment_grid-item">중중중중기</div>
				<div class="book_detail_comment_grid-item">중중중기중</div>
			</div>
		</div>
	</div>
@endsection

@section('defer-js')
<script src="{{ asset('/js/common.js') }}" defer></script>
<script src="{{ asset('/js/bookDetail.js') }}" defer></script>
@endsection