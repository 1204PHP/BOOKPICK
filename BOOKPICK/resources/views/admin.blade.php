@extends('layout.layout')
{{-- layout.blade.php 상속 --}}
@section('title', 'admin')
{{-- title로 Main 표기 --}}
@section('content')

{{-- BookInfo --}}
	<br>
	<h1>BookInfo Table</h1>
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
	<div class="admin_pagination">{{ $bookTableData->links('pagination::default') }} </div>
	<br>
	<form action="{{route('postAdminbookInfo')}}" method="POST">
		@csrf
		<button type="submit" name="action" value="ItemNewAll">신간 전체 리스트 초기 책정보500개 등록</button><br>
    	<button type="submit" name="action" value="ItemNewSpecial">주목할 만한 신간 리스트 초기 책정보500개 등록</button><br>
    	<button type="submit" name="action" value="Bestseller">베스트셀러 초기 책정보500개 등록</button><br>
    	<button type="submit" name="action" value="BlogBest">블로거 베스트셀러 초기 책정보500개 등록</button><br>

	</form>
{{-- bookApi --}}
	<h1>BookApi Table</h1>
	<div class="table-container">
		<table>
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
	<form action="{{route('postAdminbookApi')}}" method="POST">
		@csrf
		<button type="submit" name="action" value="ItemNewAll">신간 전체 리스트 api추가</button><br>
    	<button type="submit" name="action" value="ItemNewSpecial">주목할 만한 신간 리스트 api추가</button><br>
    	<button type="submit" name="action" value="Bestseller">베스트셀러 api추가</button><br>
    	<button type="submit" name="action" value="BlogBest">블로거 베스트셀러 api추가</button><br>
	</form>
	<br><br>

{{-- ApiCate --}}
	<h1>ApiCate Table</h1>
	<div class="table-container">
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
	<div class="admin_pagination">{{ $apiCateTableData->links('pagination::default') }} </div>
	<form action="{{route('postAdminApiCateAuto')}}" method="POST">
		@csrf
		<button type="submit">초기등록버튼</button>
	</form>
	<p>//초기등록버튼 클릭시 자동 등록, ac_name입력하고 임의추가 입력시 수동 등록가능</p>
	<form action="{{route('postAdminApiCate')}}" method="POST">
		@csrf
		<input type="text" placeholder="ac_name" name="ApiCateInput" value="">
		<button type="submit">임의추가</button>
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
	</form> --}}
@endsection