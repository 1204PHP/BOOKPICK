<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class Book_detail_comment_state extends Model
{
    use HasFactory, softDeletes;
    
    protected $primaryKey = 'bdcs_id';
    public $timestamps = true;

    protected $fillable = [
        'bdcs_flg',
        'bdc_id',
        'u_id',
    ];

    public function bookDetailComment() {
        return $this->belongsTo(Book_detail_comment::class, 'bdc_id')->withTrashed();
    }
    public function user() {
        return $this->belongsTo(User::class, 'u_id')->withTrashed();
    }
}
