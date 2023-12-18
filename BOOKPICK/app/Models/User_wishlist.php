<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_wishlist extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'uw_id';
    public $timestamps = true;
}
