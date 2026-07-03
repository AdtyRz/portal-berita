<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Announcement extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'title', 'slug', 'excerpt', 'content', 'thumbnail',
        'priority', 'status', 'publish_date', 'expired_date',
        'meta_title', 'meta_description', 'total_views',
    ];

    protected $casts = [
        'publish_date' => 'datetime',
        'expired_date' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($announcement) {
            if (empty($announcement->slug)) {
                $announcement->slug = Str::slug($announcement->title);
            }
        });
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')
            ->whereNotNull('publish_date')
            ->where('publish_date', '<=', now());
    }

    public function scopeActive($query)
    {
        return $query->published()
            ->where(function ($q) {
                $q->whereNull('expired_date')
                  ->orWhere('expired_date', '>', now());
            });
    }

    public function scopeUrgent($query)
    {
        return $query->where('priority', 'urgent');
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('publish_date', 'desc');
    }

    public function getThumbnailUrlAttribute(): string
    {
        return $this->thumbnail ? asset('storage/' . $this->thumbnail) : asset('images/default-announcement.jpg');
    }
}
