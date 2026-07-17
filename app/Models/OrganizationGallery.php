<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrganizationGallery extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'organization_id',
        'title',
        'description',
        'image',
        'event_type',
        'event_date',
        'location',
        'order',
        'is_featured',
    ];

    protected $casts = [
        'event_date' => 'date',
        'is_featured' => 'boolean',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function getImageUrlAttribute(): string
    {
        return $this->image ? asset('storage/' . $this->image) : asset('images/default.jpg');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('event_date', 'desc');
    }

    public function scopeByYear($query, $year)
    {
        return $query->whereYear('event_date', $year);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('event_type', $type);
    }
}