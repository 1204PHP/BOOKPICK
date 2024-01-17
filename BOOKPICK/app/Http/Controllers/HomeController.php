<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book_info;
use App\Models\Book_api;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User_library;
use App\Models\User_wishlist;

class HomeController extends Controller
{
    public function index()
    {   
        Log::debug("--------------홈 화면 출력------------------------");
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

        // 인기 도서 찜 순위!!
        $hotWishListNum = User_wishlist::select('user_wishlists.b_id','book_infos.b_title', DB::raw('COUNT(*) as count'))
                            ->join('book_infos', 'user_wishlists.b_id', '=', 'book_infos.b_id')
                            ->where('user_wishlists.uw_flg', 0)
                            ->groupBy('user_wishlists.b_id','book_infos.b_title')
                            ->orderByDesc('count')
                            ->limit(5)
                            ->get();
        
        // 북픽 추천 도서
        $userId = Session::get('u_id');
        if ($userId) {
            $resultFromQuery = User_library::select('book_infos.b_sub_cate', DB::raw('COUNT(*) as count'))
                ->join('book_infos', 'user_libraries.b_id', '=', 'book_infos.b_id')
                ->where('u_id',  $userId)
                ->where('ul_flg', 0)
                ->groupBy('b_sub_cate')
                ->orderByDesc('count')
                ->limit(1)
                ->first();
            if($resultFromQuery) {
                $b_sub_cate = $resultFromQuery->b_sub_cate;
                $subQuery = User_library::select('b_id')
                            ->where('u_id', $userId)
                            ->where('ul_flg',0);
                $recommendBook = Book_info::select('b_id', 'b_img_url', 'b_title', 'b_author')
                            ->whereNotIn('b_id', $subQuery)
                            ->where('b_sub_cate', $b_sub_cate)
                            ->inRandomOrder()
                            ->limit(10)
                            ->get();
                if ($recommendBook->count() < 10) {
                        $additionResult = Book_info::select('b_id', 'b_img_url', 'b_title', 'b_author')
                                                    ->where('b_sub_cate', '<>', $b_sub_cate) // 기존 결과와 중복되지 않도록
                                                    ->inRandomOrder()
                                                    ->limit(10 - $recommendBook->count()) // 부족한 만큼 추가로 가져오기
                                                    ->get();
                        $recommendBook = $recommendBook->merge($additionResult);
                    }
            } else {
                $recommendBook = Book_api::select('*')
                                ->fromSub(
                                            Book_api::where('book_apis.ac_id', 3)
                                            ->join('book_infos', 'book_apis.b_id', '=', 'book_infos.b_id')
                                            ->select('book_infos.b_id', 'book_infos.b_img_url', 'book_infos.b_title', 'book_infos.b_author','book_apis.deleted_at')
                                            ->orderByDesc('book_apis.created_at')
                                            ->where('book_apis.ba_rank', '>=', 11)
                                            ->where('book_apis.ba_rank', '<=', 50)
                                            ->limit(40),
                                            'book_apis'
                                        )
                                ->inRandomOrder()
                                ->limit(10)
                                ->get();
            }
        } else {
            $recommendBook = Book_api::select('*')
            ->fromSub(
                        Book_api::where('book_apis.ac_id', 3)
                        ->join('book_infos', 'book_apis.b_id', '=', 'book_infos.b_id')
                        ->select('book_infos.b_id', 'book_infos.b_img_url', 'book_infos.b_title', 'book_infos.b_author','book_apis.deleted_at')
                        ->orderByDesc('book_apis.created_at')
                        ->where('book_apis.ba_rank', '>=', 11)
                        ->where('book_apis.ba_rank', '<=', 50)
                        ->limit(40),
                        'book_apis'
                    )
            ->inRandomOrder()
            ->limit(10)
            ->get();
        }
        
        Log::debug("쿼리 측정 시간(ms)");
        $getQueryLog = DB::getQueryLog();
        $i=1;
        foreach ($getQueryLog as $key => $value) {
            $formattedKey = '';
            switch ($key) {
                case 0:
                    $formattedKey = '베스트셀러';
                    // $formattedValue = $value['time'];
                    $formattedValue = $value['time']."\n".$value['query'];
                    break;
                case 1:
                    $formattedKey = '신간 추천도서';
                    $formattedValue = $value['time']."\n".$value['query'];
                    break;
                case 2:
                    $formattedKey = '주목할만한 신간';
                    $formattedValue = $value['time']."\n".$value['query'];
                    break;
                case 3:
                    $formattedKey = '블로거 베스트셀러';
                    $formattedValue = $value['time']."\n".$value['query'];
                    break;
                case 4:
                    $formattedKey = '인기도서 찜 순위';
                    $formattedValue = $value['time']."\n".$value['query'];
                    break;
                default:
                    $formattedKey = '북픽 추천 도서 '."(".$i.")";
                    $formattedValue = $value['time']."\n".$value['query'];
                    $i++;
                    break;
            }
            Log::debug($formattedKey . " : " . $formattedValue);
        }
        Log::info('Client IP: ' . request()->ip());
        Log::debug("--------------홈 화면 출력 끝------------------------");
        return view( 'home' )
            ->with('bestSellerBook', $bestSellerBook)
            ->with('recommendBook', $recommendBook)
            ->with('newBook', $newBook)
            ->with('attentionBook', $attentionBook)
            ->with('bloggerBook', $bloggerBook)
            ->with('hotWishListNum', $hotWishListNum);
    }
};