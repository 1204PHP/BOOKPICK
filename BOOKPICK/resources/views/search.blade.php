@extends('layout.layout')
{{-- layout.blade.php 상속 --}}
@section('title', 'search')
{{-- title로 Main 표기 --}}
@section('content')
	@forelse($result as $key => $val)
	<span>{{$val}}</span>
	<br>
	@empty
	<span>빈배열입니다.</span>
	@endforelse
	</div>
@endsection