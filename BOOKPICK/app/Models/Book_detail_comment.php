<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class Book_detail_comment extends Model
{
    use HasFactory, softDeletes;
    
    protected $primaryKey = 'bdc_id';
    public $timestamps = true;

    public function user() {
        return $this->belongsTo(User::class, 'u_id')->withTrashed();
    }
}
