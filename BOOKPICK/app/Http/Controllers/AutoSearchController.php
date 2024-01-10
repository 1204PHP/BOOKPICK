<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book_info;

class AutoSearchController extends Controller
{
    public function autoSearch(Request $request) {
        if($request->ajax()) {
            $data = Book_info::where('b_title', 'like', '%'.$request->search.'%')
            ->orwhere('b_author', 'like', '%'.$request->search.'%')
            ->orwhere('b_sub_cate', 'like', '%'.$request->search.'%')->get();
            
            $output = '';
            Log::debug("message". $output);
            if(count($data)>0) {            
                $output ='
                    <table class="table">
                    <thead>
                    <tr>
                        <th>제목</th>
                        <th>저자</th>
                        <th>카테고리</th>
                    </tr>
                    </thead>
                    <tbody>';
    
                        
    
                        foreach($data as $bookInfo) {
                            $output .='
                            <tr>
                            <td>'.$bookInfo->b_title.'</td>
                            <td>'.$bookInfo->b_author.'</td>
                            <td>'.$bookInfo->b_sub_cate.'</td>
                            </tr>`
                            ';
                        }
                $output .='
                    </tbody>
                    </table>';
            } else {
                $output .='No results';
            }
        return $output;
        }
    }
}