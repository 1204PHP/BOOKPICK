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

class libraryController extends Controller
{
    public function libraryFinished()
    {
        $userId = Session::get('u_id');
        $currentDate = Carbon::now()->format('Y-m-d');
        if ($userId) {
            $result = User_library::join('book_infos', 'user_libraries.b_id', '=', 'book_infos.b_id')
                ->where('user_libraries.ul_flg', 0)
                ->where('user_libraries.u_id', $userId)
                ->where('user_libraries.ul_end_at', '<', $currentDate)
                ->select('book_infos.*')
                ->paginate(4);
            $resultCnt = $result->total();
            return view('library',
                ['result' => $result,
                'resultCnt' => $resultCnt]);
        }
        else {
            return redirect()->route('getLogin');
        }
    }

    public function libraryReading()
    {
        $userId = Session::get('u_id');
        $currentDate = Carbon::now()->format('Y-m-d');
        if ($userId) {
            $result = User_library::join('book_infos', 'user_libraries.b_id', '=', 'book_infos.b_id')
                ->where('user_libraries.ul_flg', 0)
                ->where('user_libraries.u_id', $userId)
                ->where('user_libraries.ul_end_at', '>=', $currentDate)
                ->select('book_infos.*')
                ->paginate(4);
            $resultCnt = $result->total();
            return view('library',
                ['result' => $result,
                'resultCnt' => $resultCnt]);
        }
        else {
            return redirect()->route('getLogin');
        }
    }

    public function librarywishlist()
    {
        $userId = Session::get('u_id');
        $currentDate = Carbon::now()->format('Y-m-d');
        if ($userId) {
            $result = User_wishlist::join('book_infos', 'user_wishlists.b_id', '=', 'book_infos.b_id')
                ->where('user_wishlists.uw_flg', 0)
                ->where('user_wishlists.u_id', $userId)
                ->select('book_infos.*')
                ->paginate(4);
            $resultCnt = $result->total();
            return view('library',
                ['result' => $result,
                'resultCnt' => $resultCnt]);
        }
        else {
            return redirect()->route('getLogin');
        }
    }

    // public function libraryPageCheck( Request $request)
    // {
    //     $buttonPageFlg = $request->input('button_page_flg');
    //     $userId = Session::get('u_id');
    //     $currentDate = Carbon::now()->format('Y-m-d');
    //     $pageNum = '';
    //     if ($userId) {
    //         if($buttonPageFlg === '1') {
    //             $pageNum = 'pageFlg_1';
    //             $result = User_library::join('book_infos', 'user_libraries.b_id', '=', 'book_infos.b_id')
    //             ->where('user_libraries.ul_flg', 0)
    //             ->where('user_libraries.u_id', $userId)
    //             ->where('user_libraries.ul_end_at', '<', $currentDate)
    //             ->select('book_infos.*')
    //             ->paginate(4, ['*'], $pageNum);
    //             $resultCnt = $result->total();
    //         } else if ($buttonPageFlg === '2') {
    //             $pageNum = 'pageFlg_2';
    //             $result = User_library::join('book_infos', 'user_libraries.b_id', '=', 'book_infos.b_id')
    //             ->where('user_libraries.ul_flg', 0)
    //             ->where('user_libraries.u_id', $userId)
    //             ->where('user_libraries.ul_end_at', '>=', $currentDate)
    //             ->select('book_infos.*')
    //             ->paginate(4, ['*'], $pageNum);
    //             $resultCnt = $result->total();
    //         } else if ($buttonPageFlg === '3') {
    //             $pageNum = 'pageFlg_3';
    //             $result = User_wishlist::join('book_infos', 'user_wishlists.b_id', '=', 'book_infos.b_id')
    //             ->where('user_wishlists.uw_flg', 0)
    //             ->where('user_wishlists.u_id', $userId)
    //             ->select('book_infos.*')
    //             ->paginate(4, ['*'], $pageNum);
    //             $resultCnt = $result->total();
    //         }
    //         return view('library',
    //             ['result' => $result,
    //             'resultCnt' => $resultCnt,
    //             'pageNum' => $pageNum]);
    //     }
    //     else {
    //         return redirect()->route('getLogin');
    //     }
    // }
}
