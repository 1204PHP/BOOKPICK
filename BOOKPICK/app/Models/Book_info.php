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

    // algolia 인덱스명 설정
    public function searchableAs() {
        return 'BOOKPICK_search';
    }




    // 외래키 연결목적 설정
    
    // 유저 서재 테이블
    public function user_library() {
        return $this->hasMany(User_library::class, 'b_id');
    }

    // 유저 서재 메모 테이블
    public function user_library_comment() {
        return $this->hasMany(User_library_comment::class, 'b_id');
    }

    // 유저 찜 목록 테이블
    public function user_wishlist() {
        return $this->hasMany(User_wishlist::class, 'b_id');
    }

    // 책 상세 댓글 테이블
    public function book_detail_comment() {
        return $this->hasMany(Book_detail_comment::class, 'b_id');
    }

    // api 테이블
    public function book_api() {
        return $this->hasMany(Book_api::class, 'b_id');
    }

    // api 카테고리 테이블
    public function api_cate() {
        return $this->hasMany(Api_cate::class, 'b_id');
    }
}