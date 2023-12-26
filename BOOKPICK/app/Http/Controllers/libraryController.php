<?php

namespace App\Http\Controllers;

use App\Models\Book_info;
use App\Models\User_library;
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
                
                Log::debug( "userId : ".$userId );
                Log::debug( "--------서재(읽은책)페이지출력 끝---------" );
                return view('library',
                    ['result' => $result,
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

                Log::debug( "userId : ".$userId );
                Log::debug( "--------서재(읽고있는책)페이지출력 끝---------" );
                return view('library',
                    ['result' => $result,
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

                Log::debug( "userId : ".$userId );
                Log::debug( "--------서재(찜목록)페이지출력 끝---------" );
                return view('library',
                    ['result' => $result,
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
