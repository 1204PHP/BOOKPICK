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
        // (인기장르보류)(미완성) 2 주목할만한신간도서

        $result = Book_info::take(6)->get();

        // 국내도서 베스트셀러
        $data =book_api::where('book_apis.ac_id', 5)
        ->whereBetween('book_apis.ba_rank', [1, 10])
        ->latest('book_apis.created_at')
        ->join('book_infos', 'book_apis.b_id', '=', 'book_infos.b_id')
        ->select('book_infos.*')
        ->inRandomOrder()
        ->get();


        return view( 'book_tour' )
            ->with('data', $data)
            ->with('result', $result);
    }
}
