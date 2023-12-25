<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class User_library extends Model
{
    use HasFactory, softDeletes;
    
    protected $primaryKey = 'ul_id';
    protected $fillable = ['u_id', 'b_id','ul_start_at','ul_end_at'];
    public $timestamps = true;

    public function user() {
        return $this->belongsTo(User::class, 'u_id')->withTrashed();
    }

    public function book_info() {
        return $this->belongsTo(Book_info::class, 'b_id')->withTrashed();
    }
}
