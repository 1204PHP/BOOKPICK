<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class book_info extends Model
{
    use HasFactory;
    protected $factory = Book_infoFactory::class;
    protected $primaryKey = 'b_id';
    public $timestamps = true;
}
