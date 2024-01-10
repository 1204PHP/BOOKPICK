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












    // ############### 알고리아 검색 



    // Algolia 인덱스 업데이트
    // public function update(Request $request, $id)
    // {
    //     Book_info::find(request('id'));
    //     // Book_info 내 생성일, 수정일, 삭제일 제외 나머지 DB 저장 값
    //     $bookInfo->b_ISBN = request('b_ISBN');
    //     $bookInfo->b_price = request('b_price');
    //     $bookInfo->b_title = request('b_title');
    //     $bookInfo->b_author = request('b_author');
    //     $bookInfo->b_summary = request('b_summary');
    //     $bookInfo->b_main_cate = request('b_main_cate');
    //     $bookInfo->b_sub_cate = request('b_sub_cate');
    //     $bookInfo->b_publication_date = request('b_publication_date');
    //     $bookInfo->b_publisher = request('b_publisher');
    //     $bookInfo->b_img_url = request('b_img_url');
    //     $bookInfo->b_product_url = request('b_product_url');
    //     // 인덱스 업데이트
    //     $bookInfo->update();
    //     Log::debug("Algolia 저장완료");
    // }

    // public function index(Request $request)
    // {   
    //     // 유저 검색 쿼리 저장
    //     $query = $request->input('query');
    //     Log::debug('Algolia Query: ' . $query);
    //     // algolia 인덱스 내 모든 정보 저장
    //     $bookInfo = book_info::search($query)->get();
    //     Log::debug('Algolia return: ' . json_encode($bookInfo));

    //     $autoSearch = $bookInfo->pluck('b_title', 'b_author', 'b_sub_cate');
    //     Log::debug('책 제목, 저자, 장르: ' . json_encode($autoSearch));
    //     return $autoSearch; <<<< json 형태로 넘어오는 값을 처리해야함 / 성찬이랑 검색결과 수정논의
    // }
}