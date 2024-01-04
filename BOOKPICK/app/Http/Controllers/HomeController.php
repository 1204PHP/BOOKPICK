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
        Log::error("--------------홈 화면 출력------------------------(ms)");
        DB::enableQueryLog();
        // 베스트 셀러 도서
        $bestSellerBook = Book_api::join('book_infos', 'book_apis.b_id', '=', 'book_infos.b_id')
        ->select('book_infos.b_id', 'book_infos.b_img_url', 'book_infos.b_title', 'book_infos.b_author')
        ->where('book_apis.ac_id', 3)
        ->where('book_apis.ba_rank', '>=', 1)
        ->where('book_apis.ba_rank', '<=', 10)
        ->orderByDesc('book_apis.created_at')
        ->orderBy('book_apis.ba_rank', 'asc')
        ->limit(10)
        ->get();
        Log::error("홈 베스트셀러 끝 쿼리측정시간 :".DB::getQueryLog()[0]['time']);

        // 북픽 추천 도서
        $recommendBook = Book_api::select('*')
                    ->fromSub(
                                Book_api::where('book_apis.ac_id', 1)
                                ->join('book_infos', 'book_apis.b_id', '=', 'book_infos.b_id')
                                ->select('book_infos.b_id', 'book_infos.b_img_url', 'book_infos.b_title', 'book_infos.b_author','book_apis.deleted_at')
                                ->orderByDesc('book_apis.created_at')
                                ->limit(50),
                                'book_apis'
                            )
                    ->inRandomOrder()
                    ->limit(10)
                    ->get();
        Log::error("홈 북픽 추천 도서 끝 쿼리측정시간 :".DB::getQueryLog()[1]['time']);

        // 신간 도서
        $newBook = Book_api::select('*')
                    ->fromSub(
                                Book_api::where('book_apis.ac_id', 1)
                                ->join('book_infos', 'book_apis.b_id', '=', 'book_infos.b_id')
                                ->select('book_infos.b_id', 'book_infos.b_img_url', 'book_infos.b_title', 'book_infos.b_author','book_apis.deleted_at')
                                ->orderByDesc('book_apis.created_at')
                                ->limit(50),
                                'book_apis'
                            )
                    ->inRandomOrder()
                    ->limit(10)
                    ->get();
        Log::error("홈 신간 도서 끝 쿼리측정시간 :".DB::getQueryLog()[2]['time']);

        // 주목할만한 신간 도서
        $attentionBook = Book_api::select('*')
                    ->fromSub(
                                Book_api::where('book_apis.ac_id', 2)
                                ->join('book_infos', 'book_apis.b_id', '=', 'book_infos.b_id')
                                ->select('book_infos.b_id', 'book_infos.b_img_url', 'book_infos.b_title', 'book_infos.b_author','book_apis.deleted_at')
                                ->orderByDesc('book_apis.created_at')
                                ->limit(50),
                                'book_apis'
                            )
                    ->inRandomOrder()
                    ->limit(10)
                    ->get();
        Log::error("홈 주목할만한 신간 도서 끝 쿼리측정시간 :".DB::getQueryLog()[3]['time']);
        
        // 블로거 베스트셀러 도서
        $bloggerBook = Book_api::select('*')
                    ->fromSub(
                                Book_api::where('book_apis.ac_id', 4)
                                ->join('book_infos', 'book_apis.b_id', '=', 'book_infos.b_id')
                                ->select('book_infos.b_id', 'book_infos.b_img_url', 'book_infos.b_title', 'book_infos.b_author','book_apis.deleted_at')
                                ->orderByDesc('book_apis.created_at')
                                ->limit(50),
                                'book_apis'
                            )
                    ->inRandomOrder()
                    ->limit(10)
                    ->get();
        Log::error("홈 블로거 베스트셀러 끝 쿼리측정시간 :".DB::getQueryLog()[4]['time']);

        Log::error("--------------홈 화면 출력 끝------------------------");
        return view( 'home' )
            ->with('bestSellerBook', $bestSellerBook)
            ->with('recommendBook', $recommendBook)
            ->with('newBook', $newBook)
            ->with('attentionBook', $attentionBook)
            ->with('bloggerBook', $bloggerBook);        
    }
};