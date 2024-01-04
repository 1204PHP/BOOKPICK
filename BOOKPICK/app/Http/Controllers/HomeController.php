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
        // 베스트셀러
        $bestSellerBook =book_api::where('book_apis.ac_id', 3)
        ->whereBetween('book_apis.ba_rank', [1, 10])
        ->latest('book_apis.created_at')
        ->join('book_infos', 'book_apis.b_id', '=', 'book_infos.b_id')
        ->select('book_infos.*')
        ->get();

        // 랜덤 도서 추천 픽 (미완성)
        $recommendBook = book_api::where('book_apis.ac_id', 1)
        ->join('book_infos', 'book_apis.b_id', '=', 'book_infos.b_id')
        ->select('book_infos.*')
        ->inRandomOrder() // 랜덤 함수
        ->limit(10)
        ->get();

        // 신간도서 15개
        $newBook = book_api::where('book_apis.ac_id', 1)
        ->latest('book_apis.created_at')
        ->join('book_infos', 'book_apis.b_id', '=', 'book_infos.b_id')
        ->select('book_infos.*')
        ->inRandomOrder()
        ->limit(15)
        ->get();

        // 주목할 만한 신간 16개
        $attentionBook = book_api::where('book_apis.ac_id', 2)
        ->latest('book_apis.created_at')
        ->join('book_infos', 'book_apis.b_id', '=', 'book_infos.b_id')
        ->select('book_infos.*')
        ->inRandomOrder()
        ->limit(15)
        ->get();

        // 블로거 베스트셀러
        $bloggerBook =book_api::where('book_apis.ac_id', 4)
        ->whereBetween('book_apis.ba_rank', [1, 10])
        ->latest('book_apis.created_at')
        ->join('book_infos', 'book_apis.b_id', '=', 'book_infos.b_id')
        ->select('book_infos.*')
        ->inRandomOrder()
        ->get();

        return view( 'home' )
            ->with('bestSellerBook', $bestSellerBook)
            ->with('recommendBook', $recommendBook)
            ->with('newBook', $newBook)
            ->with('attentionBook', $attentionBook)
            ->with('bloggerBook', $bloggerBook);        
    }
};