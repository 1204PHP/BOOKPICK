<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book_info;
use Algolia\ScoutExtended\Facades\Algolia;

class AlgoliaSearchController extends Controller
{
    /**
     * Update the given article.
     *
     * @param  Request  $request
     * @param  string  $id
     * @return Response
     */
    // algolia / DB 저장된 검색관련 데이터 전달 목적
    public function update(Request $request, $id)
    {
        $book_info = Book_info::find(request('b_id'));

        $book_info->b_title = request('b_title');
        $book_info->b_author = request('b_author');
        $book_info->b_sub_cate = request('b_sub_cate');
        /**
         *  Scout will automatically persist the
         *  changes to your Algolia search index.
         */
        $book_info->update();
    }

    // algolia / 유저 입력 값 데이터 전달 목적
    public function search(Request $request)
    {
        $query = $request->input('query');

        $results = Algolia::search('book_info')
            ->query($query)
            ->get();

        $searchResult = $results->map(function ($result) {
            return [
                'b_sub_cate' => $result['b_sub_cate'],
                'b_author' => $result['b_author'],
                'b_title' => $result['b_title'],
            ];
        })->take(5); // 5개의 결과만 반환

        return response()->json($searchResult);
    }
}