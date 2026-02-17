<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class foto extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'image',
        'is_private'
    ];

    public function category() {
        return $this->belongsTo(category::class);
    }
}
