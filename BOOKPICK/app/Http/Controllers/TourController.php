<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book_info;
use App\Models\Book_api;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TourController extends Controller
{
    public function index()
    {
        // $data =book_api::where('book_apis.ac_id', 4)
        // ->whereBetween('book_apis.ba_rank', [1, 10])
        // ->latest('book_apis.created_at')
        // ->join('book_infos', 'book_apis.b_id', '=', 'book_infos.b_id')
        // ->select('book_infos.*')
        // ->get();

        $data = Book_info::take(6)->get();
        return view('book_tour' ,['data' => $data]);
    }
}
