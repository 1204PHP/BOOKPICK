<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book_info;
use App\Models\Book_api;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index()
    {
        // $result = Book_info::take(6)->get();
        // return view('home' ,['result' => $result]);

        // $result = Book_info::join('book_apis as api', 'book_infos.b_id', '=', 'api.b_id')
        // ->select('api.ac_id', 'api.ba_rank')
        // ->orderBy('api.created_at', 'desc')
        // ->limit(5)
        // ->get();

        $result =book_api::where('book_apis.ac_id', 1)
        ->whereBetween('book_apis.ba_rank', [7, 12])
        ->latest('book_apis.created_at')
        ->join('book_infos', 'book_apis.b_id', '=', 'book_infos.b_id')
        ->select('book_infos.*')
        ->get();

        // $result = Book_info::limit(6)->get();
        $data = Book_info::take(6)->get();
        // return view('home', with('result', 'data'));

        // $data =book_api::where('book_apis.ac_id', 4)
        // ->whereBetween('book_apis.ba_rank', [6])
        // ->latest('book_apis.created_at')
        // ->join('book_infos', 'book_apis.b_id', '=', 'book_infos.b_id')
        // ->select('book_infos.*')
        // ->get();

        return view( 'home' )
            ->with('result', $result)
            ->with('data', $data);
    }

};