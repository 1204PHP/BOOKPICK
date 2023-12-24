<?php

namespace App\Http\Controllers;

use App\Models\Book_info;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SearchController extends Controller
{
    public function index( Request $request )
    {
        try {
            Log::debug( "--------검색 시작---------" );
            $ip = $request->ip();
            $searchResult = trim($request->input('result'));
            $searchStrNoSpacing = str_replace(" ","", trim($request->input('result')));
            $searchFullTxt = str_replace(" ","* ", trim($request->input('result')))."*";

            if ($searchResult) {
                // 검색어가 있는 경우
                $result = BOOK_info::WhereRaw("REPLACE(b_title,' ', '') LIKE ?", ['%' . $searchStrNoSpacing . '%'])
                ->orwhereRaw("REPLACE(b_author,' ', '') LIKE ?", ['%'. $searchStrNoSpacing. '%'])
                ->orwhereRaw("MATCH(b_title, b_author) AGAINST (? IN BOOLEAN MODE)", [$searchFullTxt])
                ->orderByRaw("CASE WHEN REPLACE(b_title,' ', '') LIKE ? THEN 1
                            WHEN REPLACE(b_author,' ', '') LIKE ? THEN 2 ELSE 3 END",
                            ['%' . $searchStrNoSpacing . '%', '%' . $searchStrNoSpacing . '%'])
                ->Paginate(60);
                $searchCnt = $result->total();
            } else {
                // 검색어가 없는 경우 모든 데이터 
                $result = Book_info::Paginate(60);
                $searchCnt = $result->total();
            }
            
            Log::debug( 'ip:'.$ip.' | 검색 내용:'.$searchResult);
            Log::debug( "--------검색 종료---------" );
            return view('search',
                ['result' => $result,
                'searchResult' => $searchResult,
                'searchCnt' => $searchCnt]);
        } catch(Exception $e) {
            Log::error( "--------검색 에러발생---------" );
            Log::error( "ip:".$ip." | 검색 내용:".$searchResult);
            Log::error( "에러내용:".$e->getMessage());
            Log::error( "-----------------------------" );
            return redirect()->route( 'index' );
        }
    }
}