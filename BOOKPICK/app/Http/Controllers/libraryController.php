<?php

namespace App\Http\Controllers;

use App\Models\Book_info;
use App\Models\User_library;
use App\Models\User_library_comment;
use App\Models\User_wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class LibraryController extends Controller
{
    public function libraryFinished()
    {   
        try {
            Log::debug( "--------서재(읽은책)페이지출력 시작---------" );
            $userId = Session::get('u_id');
            $currentDate = Carbon::now()->format('Y-m-d');

            if ($userId) {
                $result = User_library::join('book_infos', 'user_libraries.b_id', '=', 'book_infos.b_id')
                    ->where('user_libraries.ul_flg', 0)
                    ->where('user_libraries.u_id', $userId)
                    ->where('user_libraries.ul_end_at', '<', $currentDate)
                    ->select('book_infos.*')
                    ->paginate(12);
                $resultCnt = $result->total();
                
                $pichartData = User_library::join('book_infos', 'user_libraries.b_id', '=', 'book_infos.b_id')
                ->where('user_libraries.ul_flg', 0)
                ->where('user_libraries.u_id', $userId)
                ->select('book_infos.b_sub_cate', DB::raw('COUNT(*) as count'))
                ->groupBy('book_infos.b_sub_cate')
                ->orderByDesc('count')
                ->limit(5)
                ->get();
                while ($pichartData->count() < 5) {
                    $pichartData[] = (object) ['b_sub_cate' => "", 'count' => 0];
                }
                $pichartData = $pichartData->sortByDesc('count')->values();

                $now = Carbon::now();
                $nowFirstMonth = $now->copy()->startOfMonth();
                $oneMonthsAgo = $now->copy()->subMonths(1)->startOfMonth();
                $twoMonthsAgo = $now->copy()->subMonths(2)->startOfMonth();

                $chartData1 = User_library_comment::join('user_libraries', 'user_library_comments.ul_id', '=', 'user_libraries.ul_id')
                    ->where('user_libraries.u_id', $userId)
                    ->where('ul_flg', 0)
                    ->where('user_library_comments.created_at', '>=', $twoMonthsAgo)
                    ->where('user_library_comments.created_at', '<', $oneMonthsAgo)
                    ->count();
                
                $chartData2 = User_library_comment::join('user_libraries', 'user_library_comments.ul_id', '=', 'user_libraries.ul_id')
                    ->where('user_libraries.u_id', $userId)
                    ->where('ul_flg', 0)
                    ->where('user_library_comments.created_at', '>=', $oneMonthsAgo)
                    ->where('user_library_comments.created_at', '<', $nowFirstMonth)
                    ->count();
                
                $chartData3 = User_library_comment::join('user_libraries', 'user_library_comments.ul_id', '=', 'user_libraries.ul_id')
                    ->where('user_libraries.u_id', $userId)
                    ->where('ul_flg', 0)
                    ->where('user_library_comments.created_at', '>=', $nowFirstMonth)
                    ->where('user_library_comments.created_at', '<', $now)
                    ->count();

                Log::debug( "userId : ".$userId );
                Log::debug( "--------서재(읽은책)페이지출력 끝---------" );

                return view('library',
                    ['result' => $result,
                    'pichartData' => $pichartData,
                    'chartData1' => $chartData1,
                    'chartData2' => $chartData2,
                    'chartData3' => $chartData3,
                    'resultCnt' => $resultCnt]);
            }
            else {
                return redirect()->route('getLogin');
            }
        } catch(Exception $e) {
            Log::error( "--------서재(읽은책)페이지출력 에러발생---------" );
            Log::error( "에러내용:".$e->getMessage());
            Log::error( "------------------------------------" );
            return redirect()->route( 'index' );
        }
    }

    public function libraryReading()
    {
        try {
            Log::debug( "--------서재(읽고있는책)페이지출력 시작---------" );
            $userId = Session::get('u_id');
            $currentDate = Carbon::now()->format('Y-m-d');

            if ($userId) {
                $result = User_library::join('book_infos', 'user_libraries.b_id', '=', 'book_infos.b_id')
                    ->where('user_libraries.ul_flg', 0)
                    ->where('user_libraries.u_id', $userId)
                    ->where('user_libraries.ul_end_at', '>=', $currentDate)
                    ->select('book_infos.*')
                    ->paginate(12);
                $resultCnt = $result->total();

                $pichartData = User_library::join('book_infos', 'user_libraries.b_id', '=', 'book_infos.b_id')
                ->where('user_libraries.ul_flg', 0)
                ->where('user_libraries.u_id', $userId)
                ->select('book_infos.b_sub_cate', DB::raw('COUNT(*) as count'))
                ->groupBy('book_infos.b_sub_cate')
                ->orderByDesc('count')
                ->limit(5)
                ->get();
                while ($pichartData->count() < 5) {
                    $pichartData[] = (object) ['b_sub_cate' => "없음", 'count' => 0];
                }
                $pichartData = $pichartData->sortByDesc('count')->values();

                $now = Carbon::now();
                $nowFirstMonth = $now->copy()->startOfMonth();
                $oneMonthsAgo = $now->copy()->subMonths(1)->startOfMonth();
                $twoMonthsAgo = $now->copy()->subMonths(2)->startOfMonth();

                $chartData1 = User_library_comment::join('user_libraries', 'user_library_comments.ul_id', '=', 'user_libraries.ul_id')
                    ->where('user_libraries.u_id', $userId)
                    ->where('ul_flg', 0)
                    ->where('user_library_comments.created_at', '>=', $twoMonthsAgo)
                    ->where('user_library_comments.created_at', '<', $oneMonthsAgo)
                    ->count();
                
                $chartData2 = User_library_comment::join('user_libraries', 'user_library_comments.ul_id', '=', 'user_libraries.ul_id')
                    ->where('user_libraries.u_id', $userId)
                    ->where('ul_flg', 0)
                    ->where('user_library_comments.created_at', '>=', $oneMonthsAgo)
                    ->where('user_library_comments.created_at', '<', $nowFirstMonth)
                    ->count();
                
                $chartData3 = User_library_comment::join('user_libraries', 'user_library_comments.ul_id', '=', 'user_libraries.ul_id')
                    ->where('user_libraries.u_id', $userId)
                    ->where('ul_flg', 0)
                    ->where('user_library_comments.created_at', '>=', $nowFirstMonth)
                    ->where('user_library_comments.created_at', '<', $now)
                    ->count();
                Log::debug( "userId : ".$userId );
                Log::debug( "--------서재(읽고있는책)페이지출력 끝---------" );
                return view('library',
                    ['result' => $result,
                    'pichartData' => $pichartData,
                    'chartData1' => $chartData1,
                    'chartData2' => $chartData2,
                    'chartData3' => $chartData3,
                    'resultCnt' => $resultCnt]);
            }
            else {
                return redirect()->route('getLogin');
            }
        } catch(Exception $e) {
            Log::error( "--------서재(읽고있는책)페이지출력 에러발생---------" );
            Log::error( "에러내용:".$e->getMessage());
            Log::error( "------------------------------------" );
            return redirect()->route( 'index' );
        }
    }

    public function librarywishlist()
    {
        try {
            Log::debug( "--------서재(찜목록)페이지출력 시작---------" );
            $userId = Session::get('u_id');
            $currentDate = Carbon::now()->format('Y-m-d');

            if ($userId) {
                $result = User_wishlist::join('book_infos', 'user_wishlists.b_id', '=', 'book_infos.b_id')
                    ->where('user_wishlists.uw_flg', 0)
                    ->where('user_wishlists.u_id', $userId)
                    ->select('book_infos.*')
                    ->paginate(12);
                $resultCnt = $result->total();

                $pichartData = User_library::join('book_infos', 'user_libraries.b_id', '=', 'book_infos.b_id')
                    ->where('user_libraries.ul_flg', 0)
                    ->where('user_libraries.u_id', $userId)
                    ->select('book_infos.b_sub_cate', DB::raw('COUNT(*) as count'))
                    ->groupBy('book_infos.b_sub_cate')
                    ->orderByDesc('count')
                    ->limit(5)
                    ->get();
                while ($pichartData->count() < 5) {
                    $pichartData[] = (object) ['b_sub_cate' => "없음", 'count' => 0];
                }
                $pichartData = $pichartData->sortByDesc('count')->values();

                $now = Carbon::now();
                $nowFirstMonth = $now->copy()->startOfMonth();
                $oneMonthsAgo = $now->copy()->subMonths(1)->startOfMonth();
                $twoMonthsAgo = $now->copy()->subMonths(2)->startOfMonth();

                $chartData1 = User_library_comment::join('user_libraries', 'user_library_comments.ul_id', '=', 'user_libraries.ul_id')
                    ->where('user_libraries.u_id', $userId)
                    ->where('ul_flg', 0)
                    ->where('user_library_comments.created_at', '>=', $twoMonthsAgo)
                    ->where('user_library_comments.created_at', '<', $oneMonthsAgo)
                    ->count();
                
                $chartData2 = User_library_comment::join('user_libraries', 'user_library_comments.ul_id', '=', 'user_libraries.ul_id')
                    ->where('user_libraries.u_id', $userId)
                    ->where('ul_flg', 0)
                    ->where('user_library_comments.created_at', '>=', $oneMonthsAgo)
                    ->where('user_library_comments.created_at', '<', $nowFirstMonth)
                    ->count();
                
                $chartData3 = User_library_comment::join('user_libraries', 'user_library_comments.ul_id', '=', 'user_libraries.ul_id')
                    ->where('user_libraries.u_id', $userId)
                    ->where('ul_flg', 0)
                    ->where('user_library_comments.created_at', '>=', $nowFirstMonth)
                    ->where('user_library_comments.created_at', '<', $now)
                    ->count();
                
                Log::debug( "userId : ".$userId );
                Log::debug( "--------서재(찜목록)페이지출력 끝---------" );
                return view('library',
                    ['result' => $result,
                    'pichartData' => $pichartData,
                    'chartData1' => $chartData1,
                    'chartData2' => $chartData2,
                    'chartData3' => $chartData3,
                    'resultCnt' => $resultCnt]);
                    
            }
            else {
                return redirect()->route('getLogin');
            }
        } catch(Exception $e) {
            Log::error( "--------서재(찜목록)페이지출력 에러발생---------" );
            Log::error( "에러내용:".$e->getMessage());
            Log::error( "------------------------------------" );
            return redirect()->route( 'index' );
        }
    }
}
