<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Achievement extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'title', 'slug', 'description', 'content', 'thumbnail',
        'achievement_type', 'achiever_name', 'competition_name',
        'level', 'rank', 'achievement_date', 'status',
        'meta_title', 'meta_description', 'total_views',
    ];

    protected $casts = [
        'achievement_date' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($achievement) {
            if (empty($achievement->slug)) {
                $achievement->slug = Str::slug($achievement->title);
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
        return $query->orderBy('achievement_date', 'desc');
    }

    public function scopeByLevel($query, $level)
    {
        return $query->where('level', $level);
    }

    public function getThumbnailUrlAttribute(): string
    {
        return $this->thumbnail ? asset('storage/' . $this->thumbnail) : asset('images/default-achievement.jpg');
    }
}
