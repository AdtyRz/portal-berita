<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Agenda extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'title', 'slug', 'description', 'content', 'thumbnail',
        'location', 'start_date', 'end_date', 'is_all_day', 'status',
        'meta_title', 'meta_description', 'total_views',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_all_day' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($agenda) {
            if (empty($agenda->slug)) {
                $agenda->slug = Str::slug($agenda->title);
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

    public function scopeUpcoming($query)
    {
        return $query->published()
            ->where('start_date', '>=', now())
            ->orderBy('start_date');
    }

    public function scopePast($query)
    {
        return $query->published()
            ->where('start_date', '<', now())
            ->orderBy('start_date', 'desc');
    }

    public function scopeToday($query)
    {
        return $query->published()
            ->whereDate('start_date', today());
    }

    public function getThumbnailUrlAttribute(): string
    {
        return $this->thumbnail ? asset('storage/' . $this->thumbnail) : asset('images/default-agenda.jpg');
    }

    public function isOngoing(): bool
    {
        return $this->start_date <= now() && ($this->end_date ? $this->end_date >= now() : true);
    }

    public function isUpcoming(): bool
    {
        return $this->start_date > now();
    }
}
