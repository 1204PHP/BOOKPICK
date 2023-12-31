<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class User_library_comment extends Model
{
    use HasFactory, softDeletes;
    
    protected $primaryKey = 'ulc_id';

    protected $fillable = [
        'ulc_comment',
        'ul_id',
    ];

    public $timestamps = true;

    public function user_library_comment() {
        return $this->belongsTo(User_library_comment::class, 'ul_id')->withTrashed();
    }

    public function book_info() {
        return $this->belongsTo(Book_info::class, 'b_id')->withTrashed();
    }
}
