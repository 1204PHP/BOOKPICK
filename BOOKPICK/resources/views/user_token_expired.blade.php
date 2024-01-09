@extends('layout.layout')
{{-- layout.blade.php 상속 --}}
@section('title', '유효하지 않은 링크')
{{-- title로 Main 표기 --}}
@section('content')
    <div class="withdrawal-container">    
        <p class="expired-h1">확인해주세요</p>
        <p class="expired-h2">1. 이메일 인증 가능 시간이 만료되었거나 유효한 링크가 아닙니다</p>
        <p class="expired-h2">2. 올바르지 않은 이메일 요청</p>
        <p class="expired-h2">3. 이메일 요청은 3회까지 가능합니다. 잠시 후 시도해주세요</p>

        <div class="withdrawal-button-area">
            <button type="button" class="withdrawal-main-button" onclick="location.href='{{ route('index') }}'">홈으로</button>
        </div>
    </div>
@endsection