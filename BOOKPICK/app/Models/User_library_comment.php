<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_library_comment extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'ulc_id';
    public $timestamps = true;
}
