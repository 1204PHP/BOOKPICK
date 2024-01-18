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

                $libraryRecentComment = User_library_comment::select('book_infos.b_id','book_infos.b_title', 'user_library_comments.created_at', 'user_library_comments.ulc_comment')
                ->join('user_libraries', 'user_library_comments.ul_id', '=', 'user_libraries.ul_id')
                ->join('book_infos', 'book_infos.b_id', '=', 'user_libraries.b_id')
                ->where('user_libraries.u_id', $userId)
                ->where('user_libraries.ul_flg', 0)
                ->orderby('user_library_comments.created_at', 'desc')
                ->limit(3)
                ->get();
                foreach ($libraryRecentComment as $comment) {
                    $replace_before=['/-/','/-/'];
                    $replace_after=['년 ','월 '];
                    $replace_created_at = date('Y-m-d', strtotime($comment->created_at));
                    $comment->formatted_created_at = preg_replace($replace_before, $replace_after, $replace_created_at, 1)."일";
                }
                Log::debug( "userId : ".$userId );
                Log::debug( "--------서재(읽은책)페이지출력 끝---------" );

                return view('library',
                    ['result' => $result,
                    'pichartData' => $pichartData,
                    'chartData1' => $chartData1,
                    'chartData2' => $chartData2,
                    'chartData3' => $chartData3,
                    'libraryRecentComment' => $libraryRecentComment,
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

                $libraryRecentComment = User_library_comment::select('book_infos.b_id','book_infos.b_title', 'user_library_comments.created_at', 'user_library_comments.ulc_comment')
                    ->join('user_libraries', 'user_library_comments.ul_id', '=', 'user_libraries.ul_id')
                    ->join('book_infos', 'book_infos.b_id', '=', 'user_libraries.b_id')
                    ->where('user_libraries.u_id', $userId)
                    ->where('user_libraries.ul_flg', 0)
                    ->orderby('user_library_comments.created_at', 'desc')
                    ->limit(3)
                    ->get();
                foreach ($libraryRecentComment as $comment) {
                    $replace_before=['/-/','/-/'];
                    $replace_after=['년 ','월 '];
                    $replace_created_at = date('Y-m-d', strtotime($comment->created_at));
                    $comment->formatted_created_at = preg_replace($replace_before, $replace_after, $replace_created_at, 1)."일";
                }
                Log::debug( "userId : ".$userId );
                Log::debug( "--------서재(읽고있는책)페이지출력 끝---------" );
                return view('library',
                    ['result' => $result,
                    'pichartData' => $pichartData,
                    'chartData1' => $chartData1,
                    'chartData2' => $chartData2,
                    'chartData3' => $chartData3,
                    'libraryRecentComment' => $libraryRecentComment,
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

                $libraryRecentComment = User_library_comment::select('book_infos.b_id','book_infos.b_title', 'user_library_comments.created_at', 'user_library_comments.ulc_comment')
                    ->join('user_libraries', 'user_library_comments.ul_id', '=', 'user_libraries.ul_id')
                    ->join('book_infos', 'book_infos.b_id', '=', 'user_libraries.b_id')
                    ->where('user_libraries.u_id', $userId)
                    ->where('user_libraries.ul_flg', 0)
                    ->orderby('user_library_comments.created_at', 'desc')
                    ->limit(3)
                    ->get();
                foreach ($libraryRecentComment as $comment) {
                    $replace_before=['/-/','/-/'];
                    $replace_after=['년 ','월 '];
                    $replace_created_at = date('Y-m-d', strtotime($comment->created_at));
                    $comment->formatted_created_at = preg_replace($replace_before, $replace_after, $replace_created_at, 1)."일";
                }
                Log::debug( "userId : ".$userId );
                Log::debug( "--------서재(찜목록)페이지출력 끝---------" );
                return view('library',
                    ['result' => $result,
                    'pichartData' => $pichartData,
                    'chartData1' => $chartData1,
                    'chartData2' => $chartData2,
                    'chartData3' => $chartData3,
                    'libraryRecentComment' => $libraryRecentComment,
                    'resultCnt' => $resultCnt]);
                    
            }
            else {
                Log::debug( "--------사용자 ID가 없음--------" );
                return redirect()->route('getLogin');
            }
        } catch(Exception $e) {
            Log::error( "--------서재(찜목록)페이지출력 에러발생---------" );
            Log::error( "에러내용:".$e->getMessage());
            Log::error( "------------------------------------" );
            return redirect()->route( 'index' );
        }
    }



// 나의 서재 상세 페이지
    public function libraryDetailIndex($id)
    {
        try {
            Log::debug( "--------서재 도서 상세 페이지출력 시작---------" );
            $userId = Session::get('u_id');

            if ($userId) {
                $authPage = User_library::where('b_id', $id)
                ->where('u_id', $userId)
                ->where('ul_flg', 0)
                ->first();
                if ($authPage) {
                    $result = Book_info::find($id);
                    $period = User_library::where('b_id', $id)
                        ->where('u_id', $userId)
                        ->first();
                    $commentResult = User_library_comment::where('ul_id', $period->ul_id)
                        ->orderBy('created_at', 'desc')
                        ->get();
                    $commentCount = User_library_comment::where('ul_id', $period->ul_id)
                        ->orderBy('created_at', 'desc')
                        ->count();
                    foreach ($commentResult as $comment) {
                        $replace_before=['/-/','/-/'];
                        $replace_after=['년 ','월 '];
                        $replace_created_at = date('Y-m-d', strtotime($comment->created_at));
                        $comment->formatted_created_at = preg_replace($replace_before, $replace_after, $replace_created_at, 1)."일";
                    }
                    return view('library_detail',
                    ['result' => $result,
                    'commentResult' => $commentResult,
                    'commentCount' => $commentCount,
                    'period' => $period]);
                } else {
                    return redirect()->route('getLibrarywishlist');
                }
            } else {
                Log::debug( "--------사용자 ID가 없음--------" );
                return redirect()->route('getLogin');
            }
            Log::debug( "--------서재 도서 상세 페이지출력 끝---------" );
        } catch(Exception $e) {
            Log::error( "--------서재 도서 상세 페이지출력 에러발생---------" );
            Log::error( "에러내용:".$e->getMessage());
            Log::error( "------------------------------------" );
            return redirect()->route( 'index' );
        }
    }

    public function libraryDetailUpdate(Request $request)
    {
        try {
            Log::debug( "--------서재 도서 상세 책 기간수정 시작---------" );
            $userId = Session::get('u_id');
            $b_id = $request->b_id;
            if ($userId) {
                $result = User_library::where('u_id',$userId)
                    ->where('b_id',$b_id)
                    ->first();
                    
                $result->ul_start_at = $request->detailStartDate;
                $result->ul_end_at = $request->detailEndDate;
                $result->save();
                return redirect()->route('getLibraryDetail', ['id' => $b_id]);
            } else {
                Log::debug( "--------사용자 ID가 없음--------" );
                return redirect()->route('getLogin');
            }
            Log::debug( "--------서재 도서 상세 책 기간수정 끝---------" );
        } catch(Exception $e) {
            Log::error( "--------서재 도서 상세 책 기간수정 에러발생---------" );
            Log::error( "에러내용:".$e->getMessage());
            Log::error( "------------------------------------" );
            return redirect()->route( 'index' );
        }
    }

    public function libraryDetailDelete(Request $request)
    {
        try {
            Log::debug( "--------서재 도서 상세 책 삭제 시작---------" );
            $userId = Session::get('u_id');
            $b_id = $request->b_id;
            $currentDate = Carbon::now()->format('Y-m-d');
            if ($userId) {
                $result = User_library::where('u_id',$userId)
                    ->where('b_id',$b_id)
                    ->first();
                $result->ul_flg = '1';
                $result->save();
                if($result->ul_end_at >= $currentDate) {
                    Log::debug( "--------서재 도서 상세 책 삭제 끝1---------" );
                    return redirect()->route('getLibraryReading');
                } else {
                    Log::debug( "--------서재 도서 상세 책 삭제 끝2---------" );
                    return redirect()->route('getLibraryFinished');
                }
            } else {
                Log::debug( "--------사용자 ID가 없음--------" );
                return redirect()->route('getLogin');
            }
        } catch(Exception $e) {
            Log::error( "--------서재 도서 상세 책 삭제 에러발생---------" );
            Log::error( "에러내용:".$e->getMessage());
            Log::error( "------------------------------------" );
            return redirect()->route( 'index' );
        }
    }

    public function libraryDetailCommentInsert($id, Request $request)
    {
        try {
            Log::debug( "--------서재 도서 댓글 삽입 시작---------" );
            $userId = Session::get('u_id');
            $comment = $request->content;
            if ($userId) {
                $selectPK = User_library::select('ul_id')
                    ->where('u_id',$userId)
                    ->where('b_id',$id)
                    ->first();
                $result = User_library_comment::create([
                    'ulc_comment' => $comment,
                    'ul_id' => $selectPK->ul_id,
                ]);
                return redirect()->route('getLibraryDetail', ['id' => $id]);
            } else {
                Log::debug( "--------사용자 ID가 없음---------" );
                return redirect()->route('getLogin');
            }
        } catch(Exception $e) {
            Log::error( "--------서재 도서 댓글 삽입  에러발생---------" );
            Log::error( "에러내용:".$e->getMessage());
            Log::error( "------------------------------------" );
            return redirect()->route( 'index' );
        }
    }

    public function libraryDetailCommentUpdate($id, Request $request)
    {
        try {
            Log::debug( "--------서재 도서 댓글 수정 시작---------" );
            $userId = Session::get('u_id');
            $ulc_id = $request->ulc_id1;
            $comment = $request->content;
            if ($userId) {
                User_library_comment::where('ulc_id', '=', $ulc_id)
                    ->update([
                        'ulc_comment'=>$comment
                ]);
                Log::debug( "--------서재 도서 댓글 수정 끝1---------" );
                return redirect()->route('getLibraryDetail', ['id' => $id]);
            } else {
                Log::debug( "--------사용자 ID가 없음---------" );
                return redirect()->route('getLogin');
            }
        } catch(Exception $e) {
            Log::error( "--------서재 도서 댓글 수정 에러발생---------" );
            Log::error( "에러내용:".$e->getMessage());
            Log::error( "------------------------------------" );
            return redirect()->route( 'index' );
        }
    }

    public function libraryDetailCommentDelete($id, Request $request)
    {
        try {
            Log::debug( "--------서재 도서 댓글 삭제 시작---------" );
            $userId = Session::get('u_id');
            $ulc_id = $request->ulc_id2;
            if ($userId) {
                User_library_comment::where('ulc_id', '=', $ulc_id)->delete();
                Log::debug( "--------서재 도서 댓글 삭제 끝1---------" );
                return redirect()->route('getLibraryDetail', ['id' => $id]);
            } else {
                Log::debug( "--------서재 도서 댓글 삭제 끝2---------" );
                return redirect()->route('getLogin');
            }
        } catch(Exception $e) {
            Log::error( "--------서재 도서 댓글 삭제 에러발생---------" );
            Log::error( "에러내용:".$e->getMessage());
            Log::error( "------------------------------------" );
            return redirect()->route( 'index' );
        }
    }
}