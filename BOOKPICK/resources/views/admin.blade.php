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