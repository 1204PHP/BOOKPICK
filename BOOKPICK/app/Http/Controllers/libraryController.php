<?php

namespace App\Http\Controllers;

use App\Models\Book_info;
use App\Models\User_library;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class libraryController extends Controller
{
    public function index()
    {
        $userId = Session::get('u_id');
        if ($userId) {
            $currentDate = Carbon::now();
            $result = Book_info::Paginate(4);
            // $result = UserLibrary::where('ul_flg', 0)
            // ->where('ul_end_at', '<', $currentDate)
            // ->pluck('b_id');
            
        return view('library',
            ['result' => $result]);
        }
        else {
            return redirect()->route('getLogin');
        }
        
    }
    public function libraryReading()
    {
        $result = Book_info::Paginate(4);
        return view('library',
            ['result' => $result]);
    }
    public function libraryWishlist()
    {
        
        $result = Book_info::Paginate(4);
        return view('library',
            ['result' => $result]);
    }
}
