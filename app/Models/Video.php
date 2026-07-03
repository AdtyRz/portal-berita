<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Video extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'title', 'slug', 'description', 'thumbnail',
        'video_url', 'video_type', 'video_file', 'duration',
        'status', 'meta_title', 'meta_description', 'total_views',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($video) {
            if (empty($video->slug)) {
                $video->slug = Str::slug($video->title);
            }
        });
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function getThumbnailUrlAttribute(): string
    {
        return $this->thumbnail ? asset('storage/' . $this->thumbnail) : asset('images/default-video.jpg');
    }

    public function getEmbedUrlAttribute(): ?string
    {
        if ($this->video_type === 'youtube') {
            preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&\?\/]+)/', $this->video_url, $matches);
            return isset($matches[1]) ? "https://www.youtube.com/embed/{$matches[1]}" : null;
        }
        if ($this->video_type === 'vimeo') {
            preg_match('/vimeo\.com\/(\d+)/', $this->video_url, $matches);
            return isset($matches[1]) ? "https://player.vimeo.com/video/{$matches[1]}" : null;
        }
        return null;
    }

    public function getDurationFormattedAttribute(): string
    {
        if (!$this->duration) return '00:00';
        $minutes = floor($this->duration / 60);
        $seconds = $this->duration % 60;
        return sprintf('%02d:%02d', $minutes, $seconds);
    }
}
