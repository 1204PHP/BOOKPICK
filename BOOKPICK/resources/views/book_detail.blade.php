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
				<br>
				<p class="book_datail_author_txt">{{$result->b_author}}</p>
				<br><br>
				<p class="book_datail_price_txt">가격: {{ number_format($result->b_price) }}원</p>
				<a class="book_datail_product_link" href="{{$result->b_product_url}}" target='_blank'>구매하러가기</a>
				<br><br>
				<p>{!!$result->b_summary!!}</p>
				<input type="hidden" id="wishFlg" name="wishFlg" value="{{$wishFlg}}">
				<input type="hidden" id="libraryFlg" name="libraryFlg" value="{{$libraryFlg}}">
				
				<br>
				<br>
				@if(Auth::check())
					<!-- 로그인한 경우 -->
					<form class="book_datail_form1" action="{{ route('postBookDetailWishList') }}" method="POST">
						@csrf
						<input type="hidden" id="b_id" name="b_id" value="{{$result->b_id}}">
						<button type="submit" class="book_detail_zzim" onclick="BookDetailWishFlgshowAlert()">
						@if($wishFlg === 0)
							찜 삭제	
						@elseif($wishFlg === 1)
							찜 하기
						@endif
						</button>
					</form>

					<form class="book_datail_form2" action="{{ route('postBookDetailUserLibrary') }}" onsubmit="BookDetailLibraryFlgshowAlert(event)" name="validateForm" method="POST">
						@csrf
						<input type="hidden" id="library_b_id" name="library_b_id" value="{{$result->b_id}}">
						
						@if($libraryFlg ===1)
								<button type="button" class="book_detail_zzim1" onclick="BookDetailopenModal()">
									서재에 추가
								</button>
								<br>
								<div id="myModal" class="modal">
									<div class="modal-content">
										<label class="modal-content_txt" for="detailStartDate">독서 시작 날짜:</label>
										<input type="date" id="detailStartDate" name="detailStartDate" value="{{ now()->format('Y-m-d') }}">
										<span class="modal-content_txt" >에서</span>
										<span class="modal-content-br"><br></span>
										<label class="modal-content_txt" for="detailEndDate">독서 마감 날짜:</label>
										<input type="date" id="detailEndDate" name="detailEndDate" value="{{ now()->format('Y-m-d') }}">
										<span class="modal-content_txt">까지</span>
										
										<button class="modal-content-submit" type="submit">등록</button>
									</div>
								</div>
						@endif

						@if($libraryFlg ===0)
							<button type="submit" class="book_detail_zzim1">
							서재에서 삭제
							</button>
						@endif
					</form>
				@else
				{{-- 로그인 안한 경우 --}}
					<button type="button" class="book_detail_zzim" onclick="BookDetailWishFlgshowAlert()">찜 하기</button>
					<button type="submit" class="book_detail_zzim1" onclick="BookDetailLibraryFlgshowAlert()">서재에 추가</button>
				@endif
			</div>
		</div>
	</div>
		{{--연관 책 추천 여역  --}}
	{{-- <div class="book_detail_box1">
        <div class="book_detail_title">
            <strong>검색 연관 도서</strong>
            <p>이런 도서는 어떠세요?</p>
        </div>
        <ul class="book_detail_slide_container" id="slide">
            @forelse($result as $val)
            <li class="book_detail_slide-box">
				<img src="..." alt="...">
                <p></p>
                <p></p>
            </li>
            @empty
                비어있음
            @endforelse
        </ul>
    </div> --}}
		{{--댓글 작성 영역  --}}
	{{-- <div class="book_detail_comment_layout">
		<div class="book_detail_comment_section-box">
			<div class="book_detail_comment_section-1">
				<strong>독자들의 코멘트</strong>
				<button id="book_detail_comment_modal_btn" type="button">코멘트 작성</button>
				<div class="book_detail_comment_modal">
					<div class="book_detail_comment_modal_body">
					<form class="book_detail_comment_modal_form">
						<div class="book_detail_comment_modal_header">
							<label for="title"></label>
							<textarea id="title" name="title" rows="1" cols="30" maxlength=50 placeholder="제목을 입력해 주세요"></textarea>
						</div>
						<br>
						<div class="book_detail_comment_modal_content">
							<label for="content"></label>
							<textarea id="content" name="content" rows="4" cols="30" maxlength=300 placeholder="댓글을 남겨주세요"></textarea>
						<br>
						</div>
						<div class="book_detail_comment_modal_footer">
							<button class="book_detail_comment_close_modal_btn" type="button">취소</button>
							<button class="book_detail_comment_complete_modal_btn" type="submit">댓글 등록</button>
						</div>
					</form>
					</div>
				</div>
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
	</div> --}}
@endsection

@section('defer-js')
<script src="{{ asset('/js/common.js') }}" defer></script>
<script src="{{ asset('/js/bookDetail.js') }}" defer></script>
@endsection