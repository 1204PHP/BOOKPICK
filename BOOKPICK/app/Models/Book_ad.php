<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book_ad extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'ba_id';
    public $timestamps = true;
}
