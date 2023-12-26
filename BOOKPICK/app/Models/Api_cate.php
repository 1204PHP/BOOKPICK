<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class Api_cate extends Model
{
    use HasFactory, softDeletes;
    
    protected $primaryKey = 'ac_id';

    public function book_api() {
        return $this->belongsTo(Book_api::class, 'ba_id')->withTrashed();
    }
}
