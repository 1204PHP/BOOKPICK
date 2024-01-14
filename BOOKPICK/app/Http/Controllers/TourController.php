<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\book_info;
use App\Models\Book_detail_comment;
use App\Models\Book_api;
use App\Models\User;
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

        // 도서 중 댓글 가장 많이 달린 3개 게시물
        // $bookCommentTop3 = Book_detail_comment::with(['book_info', 'user'])
        // ->select('u_email', 'b_title', 'bdc_comment')
        // ->orderByDesc(DB::raw('(SELECT COUNT(*) FROM book_detail_comments WHERE b_id = book_detail_comments.b_id)'))
        // ->limit(3)
        // ->get();
        $bookComment3 = DB::table('book_detail_comments as BDC')
        ->join('book_infos as BI', 'BDC.b_id', '=', 'BI.b_id')
        ->join('users as U', 'BDC.u_id', '=', 'U.u_id')
        ->select('U.u_email', 'BI.b_id', 'BI.b_title', 'BDC.bdc_comment')
        ->orderBy(DB::raw('(SELECT COUNT(*) FROM book_detail_comments WHERE b_id = BI.b_id)'), 'DESC')
        ->limit(3)
        ->get();

        $bookCommentTop3 = json_decode($bookComment3, true);
        Log::debug('bookComment3:' . $bookComment3);

        return view( 'book_tour' )
            ->with('newBook', $newBook)
            ->with('attentionBook', $attentionBook)
            ->with('bestSellerBook', $bestSellerBook)
            ->with('bookCommentTop3', $bookCommentTop3);
    }
}
