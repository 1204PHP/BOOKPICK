<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;
use Laravel\Scout\Searchable;

class book_info_autoSearch extends Model
{
    use HasFactory, Searchable;
    
    protected $fillable = [
        'b_sub_cate',
        'b_title',
    ];

    // 실시간 연관검색어 데이터 연동
    public static function importDataFromBookInfo()
    {
        $bookInfoData = Book_info::select('b_sub_cate', 'b_title')->get();
    
        foreach ($bookInfoData as $bookInfo) {
            self::create([
                'b_sub_cate' => $bookInfo->b_sub_cate,
                'b_title' => $bookInfo->b_title,
            ]);
        }
    }
}
