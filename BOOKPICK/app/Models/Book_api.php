<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class Book_api extends Model
{
    use HasFactory, softDeletes;
    protected $primaryKey = 'ba_id';
    protected $fillable = [
        'ba_rank',
        'b_id',
        'ac_id',
    ];
    public $timestamps = true;
    public function book_info() {
        return $this->belongsTo(Book_info::class, 'b_id')->withTrashed();
    }

    // 외래키 연결목적 설정

    // api카테고리 테이블
    public function book_api() {
        return $this->hasMany(Book_api::class, 'ba_id');
    }
}
