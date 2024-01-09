@extends('layout.layout')
{{-- layout.blade.php 상속 --}}
@section('title', '유효하지 않은 링크')
{{-- title로 Main 표기 --}}
@section('content')
<div class="withdrawal-container">
    
        <p class="withdrawal-h1">이메일 인증 가능 시간이 만료되었거나 유효한 링크가 아닙니다</p>
        
        <div class="withdrawal-button-area">
            <button type="button" class="withdrawal-main-button" onclick="location.href='{{ route('index') }}'">홈으로</button>
        </div>            

</div>
@endsection