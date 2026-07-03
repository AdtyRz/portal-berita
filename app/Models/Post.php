<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id', 'user_id', 'title', 'slug', 'excerpt', 'content',
        'thumbnail', 'status', 'featured', 'breaking_news', 'publish_date',
        'meta_title', 'meta_description', 'keywords',
        'total_views', 'total_likes', 'total_comments', 'total_shares',
    ];

    protected $casts = [
        'featured' => 'boolean',
        'breaking_news' => 'boolean',
        'publish_date' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tags');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function approvedComments()
    {
        return $this->hasMany(Comment::class)->where('is_approved', true);
    }

    public function reactions()
    {
        return $this->morphMany(Reaction::class, 'reactable');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')
            ->whereNotNull('publish_date')
            ->where('publish_date', '<=', now());
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeBreakingNews($query)
    {
        return $query->where('breaking_news', true);
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeArchived($query)
    {
        return $query->where('status', 'archived');
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('publish_date', 'desc');
    }

    public function scopePopular($query)
    {
        return $query->orderBy('total_views', 'desc');
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('excerpt', 'like', "%{$search}%")
              ->orWhere('content', 'like', "%{$search}%");
        });
    }

    public function getThumbnailUrlAttribute(): string
    {
        return $this->thumbnail ? asset('storage/' . $this->thumbnail) : asset('images/default-post.jpg');
    }

    public function incrementViews(): void
    {
        $this->increment('total_views');
    }

    public function relatedPosts($limit = 4)
    {
        return static::published()
            ->where('category_id', $this->category_id)
            ->where('id', '!=', $this->id)
            ->latest()
            ->limit($limit)
            ->get();
    }
}
