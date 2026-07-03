<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title', 'image', 'link', 'position', 'order', 'status', 'start_date', 'end_date',
    ];

    protected $casts = [
        'status' => 'boolean',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', true)
            ->where(function ($q) {
                $q->where(function ($q2) {
                    $q2->whereNull('start_date')->whereNull('end_date');
                })->orWhere(function ($q2) {
                    $q2->where('start_date', '<=', now())->where('end_date', '>=', now());
                });
            });
    }

    public function scopeByPosition($query, $position)
    {
        return $query->where('position', $position);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    public function getImageUrlAttribute(): string
    {
        return asset('storage/' . $this->image);
    }
}
