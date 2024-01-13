<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book_info;
use App\Models\Book_api;
use App\Models\Book_detail_comment_state;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TourController extends Controller
{
    public function index()
    {   
        // 둘러보기 슬라이드 도서출력
        // 신간 전체 리스트
        $newBook = book_api::where('book_apis.ac_id', 1)
        ->join('book_infos', 'book_apis.b_id', '=', 'book_infos.b_id')
        ->select('book_infos.*')
        ->get();
        // 주목할 만한 신간 리스트        
        $attentionBook = book_api::where('book_apis.ac_id', 2)
        ->join('book_infos', 'book_apis.b_id', '=', 'book_infos.b_id')
        ->select('book_infos.*')
        ->get();
        // 베스트셀러
        $bestSellerBook = book_api::where('book_apis.ac_id', 3)
        ->join('book_infos', 'book_apis.b_id', '=', 'book_infos.b_id')
        ->select('book_infos.*')
        ->get();

        // 좋아요 가장 많은 3개 게시물
        // $bookDetailMemo = Book_detail_comment_state::orderBy('bdcs_flg', 'desc')->take(3)
        // ->join('book_detail_comments', 'book_detail_comment_states.bdc_id', '=', 'book_detail_comments.bdc_id')
        // ->join('book_infos', 'book_detail_comments.b_id', '=', 'book_infos.b_id')
        // ->select('book_detail_comment_states.bdcs_flg', 'book_detail_comments.bdc_comment', 'book_infos.b_title')
        // ->get();

        return view( 'book_tour' )
            ->with('newBook', $newBook)
            ->with('attentionBook', $attentionBook)
            ->with('bestSellerBook', $bestSellerBook);
            // ->with('bookDetailMemo', $bookDetailMemo);
    }
}
