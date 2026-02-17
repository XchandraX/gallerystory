<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class foto extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'image',
        'is_private',
    ];

    public function category()
    {
        return $this->belongsTo(category::class);
    }

    public function getImageUrlAttribute()
    {
        return Cloudinary::getUrl($this->image); // $this->image holds public ID
    }
}
