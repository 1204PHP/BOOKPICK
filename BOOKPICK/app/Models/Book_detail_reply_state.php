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

}
