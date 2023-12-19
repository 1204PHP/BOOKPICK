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
        $searchResult = trim($request->input('result'));
        $searchStrNoSpacing = str_replace(" ","", trim($request->input('result')));
        $searchFullTxt = str_replace(" ","* ", trim($request->input('result')))."*";
        
        // $request->input('result');
        if ($searchResult) {
            // 검색어가 제공된 경우
            $searchCnt = BOOK_info::WhereRaw("REPLACE(b_title,' ', '') LIKE ?", ['%' . $searchStrNoSpacing . '%'])
            ->orwhereRaw("REPLACE(b_author,' ', '') LIKE ?", ['%'. $searchStrNoSpacing. '%'])
            ->orwhereRaw("MATCH(b_title, b_author) AGAINST (? IN BOOLEAN MODE)", [$searchFullTxt])
            ->count();

            $result = BOOK_info::WhereRaw("REPLACE(b_title,' ', '') LIKE ?", ['%' . $searchStrNoSpacing . '%'])
            ->orwhereRaw("REPLACE(b_author,' ', '') LIKE ?", ['%'. $searchStrNoSpacing. '%'])
            ->orwhereRaw("MATCH(b_title, b_author) AGAINST (? IN BOOLEAN MODE)", [$searchFullTxt])
            ->Paginate(6);
        } else {
            // 검색어가 없는 경우 모든 데이터 
            $result = Book_info::Paginate(6);
            $searchCnt = Book_info::all()->count();
        }

        // TODO: 페이지 네이션할때 참고
        // 'posts' => $query->paginate()->appends(request()->input())
        return view('search',
                    ['result' => $result,
                    'searchResult' => $searchResult,
                    'searchCnt' => $searchCnt]);
    }
}