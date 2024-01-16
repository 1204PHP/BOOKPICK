<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class Book_detail_reply_state extends Model
{
    use HasFactory, softDeletes;
    
    protected $primaryKey = 'bdrs_id';
    public $timestamps = true;

    protected $fillable = [
        'bdrs_flg',
        'bdr_id',
        'u_id',
    ];
    public function bookDetailReply() {
        return $this->belongsTo(Book_detail_reply::class, 'bdr_id')->withTrashed();
    }
    public function user() {
        return $this->belongsTo(User::class, 'u_id')->withTrashed();
    }

}
