<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'post_id', 'user_id', 'parent_id', 'name', 'email',
        'content', 'is_approved', 'ip_address', 'user_agent',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopePending($query)
    {
        return $query->where('is_approved', false);
    }

    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }

    public function getAuthorNameAttribute(): string
    {
        return $this->user ? $this->user->name : $this->name;
    }

    public function getAuthorEmailAttribute(): string
    {
        return $this->user ? $this->user->email : $this->email;
    }

    // public function increment(string $column = 'total_views', int $amount = 1)
    // {
    //     $this->increment($column, $amount);
    // }

}
