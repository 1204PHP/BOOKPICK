<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book_info;

class AlgoliaSearchController extends Controller
{
    /**
     * Update the given article.
     *
     * @param  Request  $request
     * @param  string  $id
     * @return Response
     */
    // algolia 검색관련 데이터 전달 목적
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
}