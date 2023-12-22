<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\softDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, softDeletes;

    protected $primaryKey = 'u_id';

    public $timestamps = true;
    
    protected $fillable = [
        'u_email',
        'u_password',
        'u_name',
        'u_birthdate',
        'u_tel',
        'u_postcode',
        'u_basic_address',
        'u_detail_address',
        
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    // User 모델 외래키 softdelete 처리 목적 모델 정의
    // 유저 찜 목록 테이블
    public function user_wishlist() {
        return $this->hasMany(User_wishlist::class, 'uw_id');
    }

    // 유저 서재 테이블
    public function user_library() {
        return $this->hasMany(User_library::class, 'ul_id');
    }

    // 유저 서재 메모 테이블
    public function user_library_comments() {
        return $this->hasMany(User_library_comments::class, 'ulc_id');
    }

    // 책 상세 댓글 테이블
    public function book_detail_comments() {
        return $this->hasMany(Book_detail_comments::class, 'bdc_id');
    }
}
