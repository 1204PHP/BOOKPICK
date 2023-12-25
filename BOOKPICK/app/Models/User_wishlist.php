<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class User_wishlist extends Model
{
    use HasFactory, softDeletes;
    
    protected $primaryKey = 'uw_id';
    protected $fillable = ['u_id', 'b_id','uw_flg'];
    public $timestamps = true;

    public function user() {
        return $this->belongsTo(User::class, 'u_id')->withTrashed();
    }

    public function book_info() {
        return $this->belongsTo(Book_info::class, 'b_id')->withTrashed();
    }
}
