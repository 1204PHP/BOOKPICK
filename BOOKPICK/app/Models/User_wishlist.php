<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_wishlist extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'uw_id';
    protected $fillable = ['u_id', 'b_id','uw_flg'];
    public $timestamps = true;
}
