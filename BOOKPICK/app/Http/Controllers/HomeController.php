<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book_info;
use App\Models\Book_api;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index()
    {
        // $result = Book_info::take(6)->get();
        // return view('home' ,['result' => $result]);

        // $result = Book_info::join('book_apis as api', 'book_infos.b_id', '=', 'api.b_id')
        // ->select('api.ac_id', 'api.ba_rank')
        // ->orderBy('api.created_at', 'desc')
        // ->limit(5)
        // ->get();
        
        // 베스트셀러 도서
        $data =book_api::where('book_apis.ac_id', 4)
        ->whereBetween('book_apis.ba_rank', [1, 10])
        ->latest('book_apis.created_at')
        ->join('book_infos', 'book_apis.b_id', '=', 'book_infos.b_id')
        ->select('book_infos.*')
        ->get();

        // 랜덤 도서 추천 픽 (미완성)
        $rand = book_api::where('book_apis.ac_id', 1)
        ->join('book_infos', 'book_apis.b_id', '=', 'book_infos.b_id')
        ->select('book_infos.*')
        ->inRandomOrder() // 랜덤 함수
        ->limit(10) // 최대 6개의 결과만 가져옴
        ->get();

        // 신간도서 6개만 가져오기
        $result = book_api::where('book_apis.ac_id', 1)
        ->latest('book_apis.created_at')
        ->join('book_infos', 'book_apis.b_id', '=', 'book_infos.b_id')
        ->select('book_infos.*')
        ->inRandomOrder()
        ->limit(15) // 최대 6개의 결과만 가져옴
        ->get();

        // 추천 도서

        return view( 'home' )
            ->with('data', $data)
            ->with('rand', $rand)
            ->with('result', $result);
        // $result = Book_info::limit(6)->get();
        // $data = Book_info::take(6)->get();
        // return view('home', with('result', 'data'));
        
    }

};