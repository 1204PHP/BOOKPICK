@extends('layout.layout')
{{-- layout.blade.php 상속 --}}
@section('title', 'admin')
{{-- title로 Main 표기 --}}
@section('content')

{{-- BookInfo --}}
	<div class="table-container">
		<h1>BookInfo Table</h1>
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
	<div class="admin_pagination">{{ $bookTableData->links('pagination::default') }} </div>
	<form action="{{route('postAdminBookInfo')}}" method="POST">
		@csrf
		<input type="text" placeholder="ac_id" name="ApiCateInput" value="">
		<button type="submit">책정보추가</button>
	</form>
	<br><br>
	
{{-- bookApi --}}
	<div class="table-container">
		<table>
			<h1>BookApi Table</h1>
			<thead>
				<tr>
					@foreach($bookApiTableColumn as $column)
					<th>{{$column}}</th>
					@endforeach
				</tr>
			</thead>
			<tbody>
				@foreach($bookApiTableData as $data)
					<tr>
						@foreach($bookApiTableColumn as $column)
						<td>{{$data->$column}}</td>
						@endforeach
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	<div class="admin_pagination">{{ $bookApiTableData->links('pagination::default') }} </div>

{{-- ApiCate --}}
	<div class="table-container">
		<h1>ApiCate Table</h1>
        <table>
            <thead>
                <tr>
					@foreach($apiCateTableColumn as $column)
                    <th>{{$column}}</th>
					@endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($apiCateTableData as $data)
					<tr>
						@foreach($apiCateTableColumn as $column)
						<td>{{$data->$column}}</td>
						@endforeach
					</tr>
                @endforeach
            </tbody>
        </table>
    </div>
	<div class="admin_pagination">{{ $bookApiTableData->links('pagination::default') }} </div>
	<form action="{{route('postAdminApiCate')}}" method="POST">
		@csrf
		<input type="text" placeholder="ac_name" name="ApiCateInput" value="">
		<button type="submit">추가</button>
	</form>
	<br><br>
	
	
	{{--
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