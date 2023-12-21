<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book_info;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index()
    {
        // $result = Book_info::take(6)->get();
        // return view('home' ,['result' => $result]);
        
        $result = Book_info::take(6)->get();
        $data = Book_info::take(4)->get();

        return view('home', compact('result', 'data'));
    }
    
}
