@extends('layout.layout')
{{-- layout.blade.php 상속 --}}
@section('title', 'admin')
{{-- title로 Main 표기 --}}
@section('content')
	<form action="{{route('postAdmin.index')}}" method="POST">
		@csrf
		<button type="submit">책정보추가</button>
	</form>
	<div class="table-container">
        <table>
            <thead>
                <tr>
					@foreach($bookTableColumn as $column)
                    <th>{{$column}}</th>
					@endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($bookTableData as $data)
					<tr>
						@foreach($bookTableColumn as $column)
						<td>{{$data->$column}}</td>
						@endforeach
					</tr>
                @endforeach
            </tbody>
        </table>
    </div>
	<div style="text-align: center;">
		@php
			$currentPage = $bookTableData->currentPage();
			$lastPage = $bookTableData->lastPage();
			$numToShow = 5; // 한 번에 표시할 페이지 번호의 개수
			$start = max(1, $currentPage - 2);
			$end = min($start + 4, $lastPage);
			$start = max(1, $end - 4);
		@endphp

		<a href="{{ $bookTableData->url(1)}}">처음</a>
		@if ($currentPage > 1)
			<a href="{{ $bookTableData->previousPageUrl() }}">이전</a>
		@endif
		@for($i = $start; $i <= $end; $i++)
			<a href="{{$bookTableData->url($i)}}" @if($i == $currentPage)@endif>{{$i}}</a>
		@endfor
		@if ($currentPage < $lastPage )
			<a href="{{$bookTableData->nextPageUrl()}}">다음</a>
		@endif
		<a href="{{$bookTableData->url($lastPage)}}">맨끝</a>
	</div>
	{{-- <form action="/home" method="POST">
		@csrf
		<button type="submit">POST버튼</button>
	</form>
	<form action="/home" method="POST">
		@csrf
		<button type="submit">POST버튼</button>
	</form>
	<form action="/home" method="POST">
		@csrf
		<button type="submit">POST버튼</button>
	</form>
	<form action="/home" method="POST">
		@csrf
		<button type="submit">POST버튼</button>
	</form>
	<form action="/home" method="POST">
		@csrf
		<button type="submit">POST버튼</button>
	</form>
	<form action="/home" method="POST">
		@csrf
		<button type="submit">POST버튼</button>
	</form> --}}
@endsection