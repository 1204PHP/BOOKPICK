<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_library extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'ul_id';
    protected $fillable = ['u_id', 'b_id','ul_start_at','ul_end_at'];
    public $timestamps = true;
}
