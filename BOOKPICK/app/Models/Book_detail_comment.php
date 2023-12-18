<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book_detail_comment extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'bdc_id';
    public $timestamps = true;
}
