<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_library extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'ul_id';
    public $timestamps = true;
}