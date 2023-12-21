<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book_info;
use App\Models\Book_apis;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index()
    {
        // $result = Book_info::take(6)->get();
        // return view('home' ,['result' => $result]);
        
        $result = Book_info::take(6)->get();
        $data = Book_apis::take(6)->get();

        
        return view('home', compact('result', 'data'));

        $books = Book_info::select('Book_info.*', 'api.ac_id', 'api.ba_rank')
        ->join('Book_info', 'books.author_id', '=', 'authors.id')
        ->where('books.published', true)
        ->get();
    }
};

SELECT api.ac_id
		,api.ba_rank
FROM book_infos AS info
	JOIN book_apis AS api
	ON info.b_id = api.b_id
order by api.created_at DESC
LIMIT 5;