<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryItem extends Model
{
    protected $fillable = ['gallery_id', 'title', 'caption', 'image', 'order'];

    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }

    public function getImageUrlAttribute(): string
    {
        return asset('storage/' . $this->image);
    }
}
