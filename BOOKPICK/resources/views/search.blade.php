@extends('layout.layout')
{{-- layout.blade.php 상속 --}}
@section('title', 'search')
{{-- title로 Main 표기 --}}
@section('content')
	{{-- <span>{{$searchTerm}}</span>에 대한 검색결과입니다. --}}
	{{-- @forelse($result as $key => $val)
	<span>{{$val}}</span>
	<br>
	@empty
	<span>정보가 없습니다.</span>
	@endforelse
	</div> --}}
	
@endsection