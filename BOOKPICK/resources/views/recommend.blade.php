@extends('layout.layout')
{{-- layout.blade.php 상속 --}}
@section('title', 'recommend')
{{-- title로 Main 표기 --}}
@section('content')
	<h1>북픽 추천 도서</h1>
	<div><img src="{{ asset('img/recommendimg1.png') }}" alt="..."></div>
@endsection