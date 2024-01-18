<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;
use Laravel\Scout\Searchable;

class book_info extends Model
{
    use HasFactory, softDeletes, Searchable;
    protected $factory = Book_infoFactory::class;
    protected $primaryKey = 'b_id';
    public $timestamps = true;
    protected $fillable = [
        'b_ISBN',
        'b_price',
        'b_title',
        'b_author',
        'b_summary',
        'b_main_cate',
        'b_sub_cate',
        'b_publication_date',
        'b_publisher',
        'b_img_url',
        'b_product_url',
    ];

    // ### algolia 설정 ###
    // 검색결과 인덱스명 설정
    public function searchableAs() {
        return 'book_info';
    }
    
    // 검색결과 import 컬럼 설정
    public function toSearchableArray()
    {
        return [
            'b_sub_cate' => $this->b_sub_cate,
            'b_title' => $this->b_title,
            'b_author' => $this->b_author,
        ];
    }

    // 검색 가능 속성 지정
    public function searchableAttributes()
    {
        return [
            'b_sub_cate',
            'b_title',
        ];
    }

    // 외래키 연결목적 설정

}