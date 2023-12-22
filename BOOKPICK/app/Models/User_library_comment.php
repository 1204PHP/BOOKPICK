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
    ];

    public $timestamps = true;
}
