<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class Book_detail_reply extends Model
{
    use HasFactory, softDeletes;
    
    protected $primaryKey = 'bdr_id';
    public $timestamps = true;

    protected $fillable = [
        'bdr_comment',
        'bdc_id',
        'u_id',
    ];
    public function book_detail_reply_state() {
        return $this->hasMany(Book_detail_reply_state::class, 'bdr_id');
    }
}
