<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book_info;
use App\Models\Book_api;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TourController extends Controller
{
    public function index()
    {   
        // 둘러보기 슬라이드 도서출력
        // 신간 전체 리스트 도서
        $data1 = book_api::where('book_apis.ac_id', 1)
        ->join('book_infos', 'book_apis.b_id', '=', 'book_infos.b_id')
        ->select('book_infos.*')
        ->get();
        // 주목할 만한 신간 리스트 도서        
        $data2 = book_api::where('book_apis.ac_id', 2)
        ->join('book_infos', 'book_apis.b_id', '=', 'book_infos.b_id')
        ->select('book_infos.*')
        ->get();
        // 베스트셀러 도서
        $data3 = book_api::where('book_apis.ac_id', 3)
        ->join('book_infos', 'book_apis.b_id', '=', 'book_infos.b_id')
        ->select('book_infos.*')
        ->get();

        // (인기장르보류)(미완성) 2 주목할만한신간도서
        $result = book_api::where('book_apis.ac_id', 2)
        ->latest('book_apis.created_at')
        ->join('book_infos', 'book_apis.b_id', '=', 'book_infos.b_id')
        ->select('book_infos.*')
        ->inRandomOrder()
        ->limit(15) // 최대 6개의 결과만 가져옴
        ->get();

        // 국내도서 베스트셀러
        $data =book_api::where('book_apis.ac_id', 4)
        ->whereBetween('book_apis.ba_rank', [1, 10])
        ->latest('book_apis.created_at')
        ->join('book_infos', 'book_apis.b_id', '=', 'book_infos.b_id')
        ->select('book_infos.*')
        ->inRandomOrder()
        ->get();


        return view( 'book_tour' )
            ->with('data1', $data1)
            ->with('data2', $data2)
            ->with('data3', $data3)
            ->with('result', $result)
            ->with('data', $data);
    }
}
