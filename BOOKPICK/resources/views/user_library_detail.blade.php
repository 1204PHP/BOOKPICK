@extends('layout.layout')
{{-- layout.blade.php 상속 --}}
@section('title', '나의 서재')
{{-- title로 Main 표기 --}}
@section('content')

{{-- 독서기록 작성 form --}}
    <div class="library-detail-insert-area">
        <form class="library-detail-insert-form" method="POST" action="{{ route('lcDetailStore') }}">
            @csrf
            <input type="hidden" name="u_id" value="{{ Session::get('id') }}">
            {{-- 작성 모달 --}}
        </form>
    </div>

{{-- 독서기록 수정 form --}}
    <div class="library-detail-put-area">
        @forelse ($data as $item)
            <form class="library-detail-put-form" method="POST" action="{{ route('lcDetailUpdate', ['User_library_comment' => $item->ulc_id]) }}">
                @csrf
                @method('PUT')

                <div class="library-detail-put-comment-area">
                    <div class="library-detail-put-comment-created_at">{{$item->created_at}}</div>
                    <span class="library-detail-put-comment">{{$item->ulc_comment}}</span>
                </div>

                @if(session('ulc_id') === $item->user_id)                    
                    <button class="library-detail-put-button" type="submit">수정하기</button>
                @endif
                {{-- 수정 모달 --}}
            </form>
        @empty                    
        @endforelse
    </div>

{{-- 독서기록 삭제 form --}}
    <div class="library-detail-delete-area">
        <form class="library-detail-delete-form" method="POST" action="{{ route('lcDetailDestory', ['User_library_comment' => $item->ulc_id]) }}">
            @csrf
            @method('DELETE')

            @if(session('ulc_id') === $item->user_id)                    
                <button class="library-detail-delete-button" type="submit">삭제하기</button>
            @endif
        </form>
    </div>















@endsection