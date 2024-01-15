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

        // 캐러셀 슬라이드 배너 b_id 연동
        $adBookIds = [8, 77, 82, 90, 96, 102, 104, 108, 116, 176];

        $adBookId = book_info::whereIn('b_id', $adBookIds)
        ->pluck('b_id');
        Log::debug("광고배너 책pk: " . $adBookId);    

        
        // 가장 많은 댓글이 달린 책의 최신 댓글과 책pk, 유저pk
        $lastestComment = Book_detail_comment::orderByDesc('created_at')->first();

        if ($lastestComment) {
            // 책pk
            $b_id = $lastestComment->b_id;
            // 유저pk
            $u_id = $lastestComment->u_id;
            // 최신 댓글 내용
            $bdc_comment = $lastestComment->bdc_comment;

            // 가장 많은 댓글이 달린 책 정보
            $bookInfo = book_info::find($b_id);
            $b_title = $bookInfo->b_title;
            $b_img_url = $bookInfo->b_img_url;

            // 댓글에 대한 유저 정보
            $user = User::find($u_id);
            $u_email = $user->u_email;

            // 결과 저장
            $lastestCommentInfo = [
                'b_id' => $b_id,
                'u_id' => $u_id,
                'b_img_url' => $b_img_url,
                'u_email' => $u_email,
                'b_title' => $b_title,
                'bdc_comment' => $bdc_comment,
            ];
            // 가장 많은 댓글이 달린 책 정보
            Log::debug("가장 많은 댓글 관련 정보" , $lastestCommentInfo);                
        }
        return view('book_tour')->with('newBook', $newBook)            
            ->with('attentionBook', $attentionBook)
            ->with('bestSellerBook', $bestSellerBook)
            ->with('adBookId', $adBookId)
            ->with('lastestCommentInfo', $lastestCommentInfo);
    }
}
