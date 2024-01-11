<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;
use Laravel\Scout\Searchable;
use App\Models\Book_info;

class book_info_autoSearch extends Model
{
    use HasFactory, Searchable;
    
    protected $fillable = [
        'b_sub_cate',
        'b_title',
    ];

    protected $table = 'book_info_auto_searches';

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

    // 실시간 연관검색어 인덱스명 설정
    public function searchableAs() {
        return 'book_info_autoSearch';
    }

    // 실시간 연관검색어 import 컬럼 설정
    public function toSearchableArray()
    {
        return [
            'b_sub_cate' => $this->b_sub_cate,
            'b_title' => $this->b_title,
        ];
    }   
}


// 실시간 연관검색어 추가
// php artisan tinker
// \App\Models\book_info_autoSearch::importDataFromBookInfo();
// = null 반환 시 처리 완료