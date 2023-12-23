<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Book_info;
use App\Models\User_wishlist;
use App\Models\User_library;
use Illuminate\Support\Facades\Session;

class BookController extends Controller
{
    public function index($id)
    {
        try {
            Log::debug( "--------도서상세출력 시작---------" );
            $userId = Session::get('u_id');
            $result = Book_info::find($id);

            // wishFlg 설정
            if ($userId) {
                $wishList = User_wishlist::where('u_id', $userId)
                ->where('b_id', $id)->first();
                if($wishList) {
                    if($wishList->uw_flg === 1) {
                        // 로그인 된상태-> 찜안한상태
                        $wishFlg = 1;
                    } else if ($wishList->uw_flg === 0)
                        // 로그인 된상태-> 찜한상태
                        $wishFlg = 0;
                } else {
                    // 로그인 된 상태-> 찜을 한번도 누르지 않은 상태
                    $wishFlg = 1;
                }
            } else {
                // 로그인 안된상테
                $wishFlg = 2;
            }

            // 서재Flg 설정
            if ($userId) {
                $library = User_library::where('u_id', $userId)
                ->where('b_id', $id)->first();
                if($library) {
                    if($library->ul_flg === 1) {
                        // 로그인 된상태-> 나의서재에 삭제되어있는 상태
                        $libraryFlg = 1;
                    } else if ($library->ul_flg === 0)
                    // 로그인 된상태-> 나의서재에 등록되어있는 상태
                        $libraryFlg = 0;
                } else {
                    // 로그인 된상태-> 나의서재에 한번도 등록한적이없는상태
                    $libraryFlg = 1;
                }
            } else {
                // 로그인 안된상테
                $libraryFlg = 2;
            }

            Log::debug( "result : ".$result );
            Log::debug( "wishFlg : ".$wishFlg );
            Log::debug( "libraryFlg : ".$libraryFlg );
            Log::debug( "--------도서상세출력 끝---------" );
            return view('book_detail',
                        ['result' => $result,
                        'wishFlg' => $wishFlg,
                        'libraryFlg' => $libraryFlg]);
        } catch(Exception $e) {
            Log::error( "--------도서상세출력 에러발생---------" );
            Log::error( "에러내용:".$e->getMessage());
            Log::error( "------------------------------------" );
            return redirect()->route( 'index' );
        }
    }

    public function bookDetailWishList( Request $request )
    {
        
        Log::debug("찜 등록 시작");
        $userId = Session::get('u_id');
        $bookId = $request->input('b_id');
        if ($userId) { // 세션에 사용자 ID가 존재하는 경우
            $record = User_wishlist::where('u_id', $userId)
                        ->where('b_id', $bookId)
                        ->first();
            if($record) {
                if($record->uw_flg===0) {
                    User_wishlist::where('u_id', $userId)
                        ->where('b_id', $bookId)
                        ->update([
                            'uw_flg'=> 1,
                    ]);
                } else if( $record->uw_flg===1 ) {
                    User_wishlist::where('u_id', $userId)
                        ->where('b_id', $bookId)
                        ->update([
                            'uw_flg'=> 0,
                    ]);
                }
            } else {
                User_wishlist::create([
                    'u_id' => $userId,
                    'b_id' => $bookId,
                ]);
            }

            Log::debug("찜 등록 끝");
            return redirect()->route('getBookDetail',['id' => $bookId]);
        } else { // 세션에 사용자 ID가 없는 경우
            Log::debug("세션에 사용자 ID가 없음");
            return redirect()->route('getLogin');
        }
    }

    public function bookDetailUserLibrary( Request $request )
    {
        $userId = Session::get('u_id');
        $bookId = $request->input('library_b_id');
        $startDate = $request->input('detailStartDate');
        $endDate = $request->input('detailEndDate');
        // TODO: 시작일, 끝나는일 유효성검사
        Log::debug("bookDetailUserLibrary 데이터삽입 시작");

        if ($userId) { // 세션에 사용자 ID가 존재하는 경우
            $record = User_library::where('u_id', $userId)
                        ->where('b_id', $bookId)
                        ->first();
            if($record) { // 해당 책 정보가 있을경우
                if($record->ul_flg===0) { // 데이터가 이미 있는 경우(플래그로 삭제처리)
                    User_library::where('u_id', $userId)
                        ->where('b_id', $bookId)
                        ->update([
                            // 'ul_start_at' => now()->format('Y-m-d'),
                            // 'ul_end_at' => now()->format('Y-m-d'),
                            'ul_flg'=> 1,
                    ]);
                } else if( $record->ul_flg===1 ) { // 데이터가 삭제 되어 있는 경우(다시 추가 처리)
                    User_library::where('u_id', $userId)
                        ->where('b_id', $bookId)
                        ->update([
                            'ul_start_at' => $startDate,
                            'ul_end_at' => $endDate,
                            'ul_flg'=> 0,
                    ]);
                }
            } else { //해당 책 정보가 없을경우
                User_library::create([
                    'u_id' => $userId,
                    'b_id' => $bookId,
                    'ul_start_at' => $startDate,
                    'ul_end_at' => $endDate,
                ]);
            }
            Log::debug("bookDetailUserLibrary 데이터삽입 끝");
            return redirect()->route('getBookDetail',['id' => $bookId]);
        } else { // 세션에 사용자 ID가 없는 경우
            Log::debug("세션에 사용자 ID가 없음");
            return redirect()->route('getLogin');
        }
    }
}
