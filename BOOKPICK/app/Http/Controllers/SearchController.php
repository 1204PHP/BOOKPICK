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
        $searchTerm = $request->input('result');

        if ($searchTerm) {
            // 검색어가 제공된 경우, 모델을 이용하여 검색 수행
            $result = Book_info::where('b_title', 'like', '%' . $searchTerm . '%')->get();
            $result = Book_info::where('b_title', 'like', '%' . $searchTerm . '%')
                    ->orWhere('b_author', 'like', '%' . $searchTerm . '%')
                    ->get();
        } else {
            // 검색어가 없는 경우 모든 데이터를 가져옴
            $result = Book_info::all();
        }

        return view('search', ['result' => $result, 'searchTerm' => $searchTerm]);
    }
}