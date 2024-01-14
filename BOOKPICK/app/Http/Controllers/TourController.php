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

        // 댓글 가장 많이 달린 도서 중 가장 최신 댓글 정보
        //(책 제목, 책 이미지, 댓글내용, 유저 이메일
        $commentTop = Book_detail_comment::join('book_infos', 'book_infos.b_id', '=', 'book_detail_comments.b_id')
        ->select('book_detail_comments.b_id', DB::raw('COUNT(*) as comment_count'), 'book_infos.b_title', 'book_infos.b_img_url')
        ->groupBy('book_detail_comments.b_id', 'book_infos.b_title', 'book_infos.b_img_url')
        ->orderByDesc('comment_count')
        ->limit(1)
        ->first();
        Log::debug("댓글 가장 많이 달린 도서/(책 pk, 댓글 갯수, 책 제목, 책 이미지주소)" . $commentTop);
        $currentCommentTop = Book_detail_comment::join('users', 'users.u_id', '=', 'book_detail_comments.u_id')
        ->select('users.u_email', 'book_detail_comments.bdc_comment', 'book_detail_comments.b_id')
        ->orderByDesc('book_detail_comments.created_at')
        ->limit(1)
        ->first();
        Log::debug("댓글 가장 많이 달린 도서/(유저이메일, 댓글내용)" .$currentCommentTop);

        $commentTopBook = [
            'commentTop' => [
                'b_id' => $commentTop->b_id,
                'b_title' => $commentTop->b_title,
                'b_img_url' => $commentTop->b_img_url,
            ],
            'currentCommentTop' => [
                'u_email' => $currentCommentTop->u_email,
                'bdc_comment' => $currentCommentTop->bdc_comment,
            ],
        ];



        return view( 'book_tour' )
            ->with('newBook', $newBook)
            ->with('attentionBook', $attentionBook)
            ->with('bestSellerBook', $bestSellerBook)
            ->with('commentTopBook', $commentTopBook);
    }
}
