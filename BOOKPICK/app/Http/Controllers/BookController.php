<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Book_info;

class BookController extends Controller
{
    public function index($id)
    {
        $result = Book_info::find($id);
        return view('book_detail' ,['result' => $result]);
    }
}
