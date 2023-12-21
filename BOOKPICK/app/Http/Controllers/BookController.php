<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Book_info;
use App\Models\User_wishlist;
use Illuminate\Support\Facades\Session;

class BookController extends Controller
{
    public function index($id)
    {
        
        $userId = Session::get('u_id');

        $result = Book_info::find($id);
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
        return view('book_detail',
                    ['result' => $result,
                    'wishFlg' => $wishFlg]);
    }

    public function bookDetailWishList( Request $request )
    {
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

            return redirect()->route('getBookDetail',['id' => $bookId]);
        } else { // 세션에 사용자 ID가 없는 경우
            Log::debug("세션에 사용자 ID가 없음");
            return redirect()->route('getLogin');
        }
    }
}
