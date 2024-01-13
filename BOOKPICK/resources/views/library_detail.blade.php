@extends('layout.layout')
{{-- layout.blade.php 상속 --}}
@section('title', '서재도서 상세 페이지')
{{-- title로 Main 표기 --}}

@php
	$replace_before=['/-/','/-/'];
	$replace_after=['년 ','월 '];
	$period_ul_start_at = preg_replace($replace_before, $replace_after, $period->ul_start_at, 1)."일";
	$period_ul_end_at = preg_replace($replace_before, $replace_after, $period->ul_end_at, 1)."일";
@endphp

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
				<a class="library_datail_link" href="{{ route('getBookDetail', ['id' => $result->b_id]) }}" target='_blank'>평가보러가기</a>
				<br><br>
				<p>{!!$result->b_summary!!}</p>
				<br><br>
				<div class="library_datail_date">읽은 기간 : {{$period_ul_start_at}} 부터 {{$period_ul_end_at}} 까지</div>
				<br>
				<form class="library_form_2" action="{{ route('deleteLibraryDetail') }}" onsubmit="return confirmDelete()" method="POST">
					@csrf
					@method('delete')
					<input type="hidden" id="b_id" name="b_id" value="{{$result->b_id}}">
					<button type="submit" class="library_detail_update">서재 삭제</button>
				</form>
				<form class="library_form_1" action="{{ route('postLibraryDetail') }}" onsubmit="LibraryDetailFlgshowAlert(event)" name="validateForm" method="POST">
					@csrf
					<input type="hidden" id="libraryFlg" name="libraryFlg" value="{{$period->ul_flg}}">
					<input type="hidden" id="b_id" name="b_id" value="{{$result->b_id}}">
					<button type="button" class="library_detail_update" onclick="LibraryDetailopenModal()">기간 수정</button>
					<div id="myModal" class="modal">
						<div class="modal-content">
							<label class="modal-content_txt" for="detailStartDate">독서 시작 날짜:</label>
							<input type="date" id="detailStartDate" name="detailStartDate" value="{{ $period->ul_start_at }}">
							<span class="modal-content_txt">에서</span>
							<br>
							<label class="modal-content_txt" for="detailEndDate">독서 마감 날짜:</label>
							<input type="date" id="detailEndDate" name="detailEndDate" value="{{ $period->ul_end_at }}">
							<span class="modal-content_txt">까지</span>
							<button class="modal-content-submit" type="submit">확인</button>
						</div>
					</div>
				</form>
				<br>
				<br>
			</div>
		</div>
	</div>
	<br>
			{{--댓글 작성 영역  --}}
	<div class="book_detail_comment_layout">
		<div class="book_detail_comment_section-box">
			<div class="book_detail_comment_section-1">
				<strong>
					@if(Auth::check())
                            <span class="library_detail_name">{{ Auth::user()->u_name }}</span>님의 독서 기록
                    @endif
				</strong>
				<button id="book_detail_comment_modal_btn" type="button">코멘트 작성</button>
				<div class="book_detail_comment_modal">
					<div class="book_detail_comment_modal_body">
					<form class="book_detail_comment_modal_form" action="{{ route('postLibraryDetailComment', ['id' => $result->b_id]) }}" method="POST">
						@csrf
						<br>
						<div class="book_detail_comment_modal_content">
							<label for="content"></label>
							<textarea id="content" class="book_detail_comment_modal_content_textarea" name="content" rows="4" cols="30" maxlength=300 spellcheck="false" placeholder="댓글을 남겨주세요"></textarea>
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
				
				<input type="hidden" id="ulc_id_cnt" name="ulc_id_cnt" value="{{$commentCount}}">
				@forelse($commentResult as $key=>$val)
					<div class="book_detail_comment_grid-item">
						<div class="dropdown">
							<button id="dropbtn{{$key}}" class="dropbtn">...</button>
							<div id="dropdown-content{{$key}}" class="dropdown-content">
								<button class="library_datail_btn" id="library_detail_comment_update_modal_btn{{$key}}" type="button">수정</button>
								<form class="library_datail_form" action="{{ route('deleteLibraryDetailComment', ['id' => $result->b_id]) }}" onclick="return commentConfirmDelete()" method="POST">
									@csrf
									@method('delete')
									<input type="hidden" id="ulc_id2" name="ulc_id2" value="{{$val->ulc_id}}">
									<button id="library_detail_comment_delete_modal_btn{{$key}}"class="library_datail_btn" type="submit">삭제</button>
								</form>
							</div>
						</div>
						{{-- 모달 --}}
						<div id="library_detail_comment_update_modal{{$key}}" class="library_detail_comment_update_modal">
							<div class="book_detail_comment_modal_body">
								<form class="book_detail_comment_modal_form" action="{{ route('putLibraryDetailComment', ['id' => $result->b_id]) }}" method="POST">
									@csrf
									@method('put')
									<input type="hidden" id="ulc_id1" name="ulc_id1" value="{{$val->ulc_id}}">
									<br>
									<div class="book_detail_comment_modal_content">
										<label for="content"></label>
										<textarea id="content" name="content" rows="4" cols="30" maxlength=300 placeholder="댓글을 남겨주세요">{{$val->ulc_comment}}</textarea>
									<br>
									</div>
									<div class="book_detail_comment_modal_footer">
										<button id="library_detail_comment_update_close_modal_btn{{$key}}" class="library_detail_comment_update_close_modal_btn" type="button">취소</button>
										<button class="library_detail_comment_update_complete_modal_btn" type="submit">댓글 등록</button>
									</div>
								</form>
							</div>
						</div>
						<span class="library_detail_comment_title">
							{{$val->formatted_created_at}}
						</span>
						<br>
						{{-- 줄바꿈 인식 --}}
						{!! nl2br(e($val->ulc_comment))!!}
					</div>
				@empty
				<div class="book_detail_comment_grid-item"></div>
				<div class="book_detail_comment_grid-item"></div>
				<div class="book_detail_comment_grid-item"></div>
				<div class="book_detail_comment_grid-item"></div>
				@endforelse
			</div>
		</div>
	</div>
@endsection

@section('defer-js')
    <script src="{{ asset('/js/common.js') }}" defer></script>
    <script src="{{ asset('/js/libraryDetail.js') }}" defer></script>
@endsection