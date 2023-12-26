<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class Api_cate extends Model
{
    use HasFactory, softDeletes;
    
    protected $primaryKey = 'ac_id';
    protected $fillable = [
        'ac_name',
    ];
    public function book_info() {
        return $this->belongsTo(Book_info::class, 'b_id')->withTrashed();
    }
}
