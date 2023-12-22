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

	<p>//url, ac_id번호 입력 후 책정보와 Api정보 둘다 자동등록</p>
	<p>http://www.aladin.co.kr/ttb/api/ItemList.aspx?ttbkey=ttbckstjddh11142001&QueryType=ItemNewAll&MaxResults=50&start=1&SearchTarget=Book&output=JS&Version=20131101&cover=big</p>
	<form action="{{route('postAdminBookInfo')}}" method="POST">
		@csrf
		<input type="text" placeholder="url"  size="200" name="url" value="">
		<br>
		<input type="text" placeholder="ac_id" name="ApiCateInput" value="">
		<button type="submit">정보추가</button>
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
	</form>
	<form action="/home" method="POST">
		@csrf
		<button type="submit">POST버튼</button>
	</form> --}}
@endsection