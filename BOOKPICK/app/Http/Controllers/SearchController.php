<?php

namespace App\Http\Controllers;

use App\Models\Book_info;
use App\Models\Book_info_autoSearch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\Paginator;


class SearchController extends Controller
{   
    // Algolia 사용 전 기존 코드
    // public function index( Request $request )
    // {
    //     try {
    //         Log::debug( "--------검색 시작---------" );
    //         $ip = $request->ip();
    //         $searchResult = trim($request->input('result'));
    //         $searchStrNoSpacing = str_replace(" ","", trim($request->input('result')));
    //         $searchFullTxt = str_replace(" ","* ", trim($request->input('result')))."*";

    //         if ($searchResult) {
    //             // 검색어가 있는 경우
    //             $result = BOOK_info::WhereRaw("REPLACE(b_title,' ', '') LIKE ?", ['%' . $searchStrNoSpacing . '%'])
    //             ->orwhereRaw("REPLACE(b_author,' ', '') LIKE ?", ['%'. $searchStrNoSpacing. '%'])
    //             ->orwhereRaw("MATCH(b_title, b_author) AGAINST (? IN BOOLEAN MODE)", [$searchFullTxt])
    //             ->orderByRaw("CASE WHEN REPLACE(b_title,' ', '') LIKE ? THEN 1
    //                         WHEN REPLACE(b_author,' ', '') LIKE ? THEN 2 ELSE 3 END",
    //                         ['%' . $searchStrNoSpacing . '%', '%' . $searchStrNoSpacing . '%'])
    //             ->Paginate(60);
    //             $searchCnt = $result->total();
    //         } else {
    //             // 검색어가 없는 경우 모든 데이터 
    //             $result = Book_info::Paginate(60);
    //             $searchCnt = $result->total();
    //         }
            
    //         Log::debug( 'ip:'.$ip.' | 검색 내용:'.$searchResult);
    //         Log::debug( "--------검색 종료---------" );
    //         return view('search',
    //             ['result' => $result,
    //             'searchResult' => $searchResult,
    //             'searchCnt' => $searchCnt]);
    //     } catch(Exception $e) {
    //         Log::error( "--------검색 에러발생---------" );
    //         Log::error( "ip:".$ip." | 검색 내용:".$searchResult);
    //         Log::error( "에러내용:".$e->getMessage());
    //         Log::error( "-----------------------------" );
    //         return redirect()->route( 'index' );
    //     }
    // }

    
    // ############### Algolia 검색 
    // 1. DB에 저장되어 있는 데이터를 Algolia index에 저장
    // 2. api 호출하여 Algolia index에 저장되어 있는 데이터 불러옴
    // 3. 검색의 정확도 및 속도 향상
    // Algolia 인덱스 업데이트
    public function update(Request $request, $id)
    {
        Book_info::find(request('id'));
        // Book_info 내 생성일, 수정일, 삭제일 제외 나머지 DB 저장 값
        $bookInfo->b_ISBN = request('b_ISBN');
        $bookInfo->b_price = request('b_price');
        $bookInfo->b_title = request('b_title');
        $bookInfo->b_author = request('b_author');
        $bookInfo->b_summary = request('b_summary');
        $bookInfo->b_main_cate = request('b_main_cate');
        $bookInfo->b_sub_cate = request('b_sub_cate');
        $bookInfo->b_publisher = request('b_publisher');
        $bookInfo->b_img_url = request('b_img_url');
        // 인덱스 업데이트
        $bookInfo->update();
        Log::debug("Algolia 저장완료");
    }

    // 유저 검색 처리
    public function index(Request $request)
    {   
        try {
            // 유저 검색 쿼리 저장
            $query = $request->input('query');

            // 유저 검색어 저장
            $searchResult = trim($request->input('query'));
            Log::debug('Algolia Query: ' . $query);

            if ($searchResult) {
                // 검색어가 있는 경우
                $bookInfo = book_info::search($query)
                    ->orderBy('b_title', 'asc')
                    ->orderBy('b_sub_cate', 'asc')
                    ->get();                
                $algoliaCnt = $bookInfo->count();
            } else {
                // 검색어가 없는 경우, 모든 정보를 가져옴                
                $bookInfo = book_info::all();
                $algoliaCnt = $bookInfo->count();
            }

            // 1페이지당 최대 60개의 데이터
            $perPage = 60;
            $currentPage = Paginator::resolveCurrentPage('page');
            $bookInfoSlice = $bookInfo->slice(($currentPage - 1) * $perPage, $perPage);

            $algoliaResult = new \Illuminate\Pagination\LengthAwarePaginator(
                $bookInfoSlice,
                $bookInfo->count(),
                $perPage,
                $currentPage,
                ['path' => Paginator::resolveCurrentPath()]
            );

            Log::debug("검색 내용: " . $searchResult);
            return view('search', [
                    'algoliaResult' => $algoliaResult,
                    'searchResult' => $searchResult,
                    'algoliaCnt' => $algoliaCnt,
                    ]);
        } catch(Exception $e) {
            Log::debug( "--------검색 에러발생---------" );
            Log::debug("검색 내용: " . $searchResult);
            Log::debug("에러: " . $e->getMessage());
            return redirect()->route('index');
        }
    }

    // 실시간 연관검색어 처리(책 장르, 제목 기준)
    public function autoSearch(Request $request)
    {
        try {
            $query = $request->input('query');
            log::debug("유저 검색어: " . $query);
            if ($query) {
                $autoSearch = Book_info_autoSearch::search($query)->get(['b_title', 'b_sub_cate'])->toArray();
                return response()->json(['autoSearch' => $autoSearch]);
            } else {
                Log::debug('검색어 없음');
                return response()->json(['autoSearch' => []]);
            }
        } catch (\Exception $e) {
            Log::debug('연관검색어 에러: ' . $e->getMessage());
            return redirect()->route('index');
        }
    }
}
