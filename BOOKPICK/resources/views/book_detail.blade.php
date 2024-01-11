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
						<button type="submit" class="book_detail_zzim @if($wishFlg ===0) liked @endif" onclick="BookDetailWishFlgshowAlert()">
						@if($wishFlg === 0)
						<svg class="heart-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100">
							<path d="M91.6 13A28.7 28.7 0 0 0 51 13l-1 1-1-1A28.7 28.7 0 0 0 8.4 53.8l1 1L50 95.3l40.5-40.6 1-1a28.6 28.6 0 0 0 0-40.6z"/>
						</svg>
							<p class="book_detail_zzim_txt">찜하기</p>
						@elseif($wishFlg === 1)
						<img class="heart-icon" src="{{asset("img/book_detail_noheart.png")}}" alt="">
							<p class="book_detail_zzim_txt">찜하기</p>
						@endif
						</button>
					</form>

					<form class="book_datail_form2" action="{{ route('postBookDetailUserLibrary') }}" onsubmit="BookDetailLibraryFlgshowAlert(event)" name="validateForm" method="POST">
						@csrf
						<input type="hidden" id="library_b_id" name="library_b_id" value="{{$result->b_id}}">
						
						@if($libraryFlg ===1)
								<button type="button" class="book_detail_zzim1" onclick="BookDetailopenModal()">
									서재 추가
								</button>
								<br>
								<div id="myModal" class="modal">
									<div class="modal-content">
										<label class="modal-content_txt" for="detailStartDate">독서 시작 날짜:</label>
										<input type="date" id="detailStartDate" name="detailStartDate" value="{{ now()->format('Y-m-d') }}">
										<span class="modal-content_txt">에서</span>
										<br>
										<label class="modal-content_txt" for="detailEndDate">독서 마감 날짜:</label>
										<input type="date" id="detailEndDate" name="detailEndDate" value="{{ now()->format('Y-m-d') }}">
										<span class="modal-content_txt">까지</span>
										<button class="modal-content-submit" type="submit">등록</button>
									</div>
								</div>
						@endif

						@if($libraryFlg ===0)
							<button type="submit" class="book_detail_zzim1">
							서재 삭제
							</button>
						@endif
					</form>
				@else
				{{-- 로그인 안한 경우 --}}
					<button type="button" class="book_detail_zzim" onclick="BookDetailConfirm()">
							<img class="heart-icon" src="{{asset("img/book_detail_noheart.png")}}" alt="">
							<p class="book_detail_zzim_txt">찜하기</p>
					</button>
					<button type="submit" class="book_detail_zzim1" onclick="BookDetailConfirm()">서재 추가</button>
				@endif
			</div>
		</div>
	</div>
	<div class="home-box3">
		<div class="home-title">
			<strong>관련 도서 추천</strong>
			<p>검색한 책과 관련된 도서를 추천해드려요!</p>
		</div>
		<ul class="slide-container" id="slide6">
			@forelse($relatedBook as $val)
			<li class="slide-box">
				<a href="{{ route('getBookDetail', ['id' => $val->b_id]) }}">
					<img src="{{$val->b_img_url}}" alt="...">
				</a>
					<p>{{$val->b_title}}</p>
					<p>{{$val->b_author}}</p>
			</li>
			@empty
				비어있음
			@endforelse
		</ul>
	</div>
	<br>

	<input id="bdc_b_id" type="hidden" value="{{$result->b_id}}">

	<div class="bdc-layout">
		<div class="bdc-box">
			{{-- 작성 영역 --}}
			<div class="bdc-write">
				{{-- 프로필 영역 --}}
				<div class="bdc-profile-area">
					<img class="bdc-profile-img" src="{{ asset('img/user.png') }}" alt="">
					<p class="bdc-profile-name">
						admin
					</p>
				</div>
				{{-- 글 영역 --}}
				<form action="{{ route('postbookDetailComment', ['id' => $result->b_id]) }}" onsubmit="return insertFormCheck()" method="POST">
					@csrf
					<div class="bdc-write-box">
						<div class="bdc-write-inbox-area font-1">
							<textarea class="bdc-write-area" id="content" rows="5" cols="30" name="content" maxlength=700 oninput="limitCharacters(); handleInput(this)"></textarea>
							<label class="bdc-write-label" for="content">
								다양한 의견이 서로 존중될 수 있도록 다른 사람에게 불쾌감을 주는 욕설, 혐오, 비하의 
								표현이나 타인의 권리를 침해하는 내용은 주의해주세요.
								모든 작성자는 
								<span class="bdc-write-label-span">
									본인이 작성한 의견에 대해 법적 책임을 갖는다는 점
								</span>
									유의하시기 바랍니다.
							</label>
						</div>
					</div>

					{{-- 버튼 영역 --}}
					<div class="bdc-write-upload">
						<span class="bdc-write-upload-cnt" id="count">
							0 / 700
						</span>
						<button type="submit" class="bdc-write-upload-btn">
							등록
						</button>
					</div>
				
				</form>
			</div>

			{{-- 제목 영역 --}}
			<div class="bdc-head">
				<p class="bdc-head-txt">
					<span id ="bdc-head-txt-count" class="bdc-head-txt-count">
						171
					</span>
					개의 댓글
				</p>
			</div>
			{{-- 리스트 영역 전체 --}}
			<div id="bdc-list" class="bdc-list">
				{{-- 리스트 --}}
				<div class="bdc-list-area">

					{{-- 리스트 상단 영역 --}}
					<div class="bdc-list-top-area">
						<img class="bdc-list-area-img" src="{{ asset('img/user.png') }}" alt="">
						<span class="bdc-list-area-name">정**</span>
						<span class="bdc-list-area-at">2024.01.01 12:57</span>
					</div>

					{{-- 리스트 중단 영역 --}}
					<div class="bdc-list-middle-area font-1">
						<p class="bdc-list-area-content">
							ㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁㅁ
						</p>
					</div>

					{{-- 리스트 하단 영역 --}}
					<div class="bdc-list-bottom-area">
						<a onclick="aaaa(3)" class="bdc-list-area-reply" href="#">
							답글
							<span class="bdc-list-area-reply-cnt">
								1
							</span>
						</a>
						<div class="bdc-list-recommend-area">
							<a href="#" class="bdc-list-area-like-box">
								<img class="bdc-dis-like-btn" src="{{ asset('img/book_detail_like.png') }}" alt="">
								<span>254</span>
							</a>
							<a href="#" class="bdc-list-area-dislike-box">
								<img class="bdc-dis-like-btn" src="{{ asset('img/book_detail_dislike.png') }}" alt="">
								<span>1</span>
							</a>
						</div>
					</div>
				</div>

				{{-- 리스트 댓글 영역 --}}
				<div class="bdc-list-reply-area">
					{{-- 리스트 상단 영역 --}}
					<div class="bdc-list-top-area">
						<img class="bdc-list-area-img" src="{{ asset('img/user.png') }}" alt="">
						<span class="bdc-list-area-name">정**</span>
						<span class="bdc-list-area-at">2024.01.01 12:57</span>
					</div>
					{{-- 리스트 중단 영역 --}}
					<div class="bdc-list-middle-area font-1">
						<p class="bdc-list-area-content">
							ㅁㅁㅁㅁㅁㅁㅁ
						</p>
					</div>
					{{-- 리스트 하단 영역 --}}
					<div class="bdc-list-reply-bottom-area">
						<div class="bdc-list-recommend-area">
							<a href="#" class="bdc-list-area-like-box">
								<img class="bdc-dis-like-btn" src="{{ asset('img/book_detail_like.png') }}" alt="">
								<span>254</span>
							</a>
							<a href="#" class="bdc-list-area-dislike-box">
								<img class="bdc-dis-like-btn" src="{{ asset('img/book_detail_dislike.png') }}" alt="">
								<span>1</span>
							</a>
						</div>
					</div>
				</div>
			</div>







		</div>
	</div>
	<br><br>
	<br><br>
@endsection

@section('defer-js')
<script src="{{ asset('/js/common.js') }}" defer></script>
<script src="{{ asset('/js/bookDetail.js') }}" defer></script>
@endsection