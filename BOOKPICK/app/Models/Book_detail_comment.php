<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class Book_detail_comment extends Model
{
    use HasFactory, softDeletes;
    
    protected $primaryKey = 'bdc_id';
    public $timestamps = true;

    protected $fillable = [
        'bdc_comment',
        'b_id',
        'u_id',
    ];
    public function user() {
        return $this->belongsTo(User::class, 'u_id')->withTrashed();
    }

    public function book_info() {
        return $this->belongsTo(Book_info::class, 'b_id')->withTrashed();
    }

    public function book_detail_reply() {
        return $this->hasMany(Book_detail_reply::class, 'bdc_id');
    }
    public function book_detail_comment_state() {
        return $this->hasMany(Book_detail_comment_state::class, 'bdc_id');
    }
}
