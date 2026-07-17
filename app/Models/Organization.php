<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Organization extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'position',
        'description',
        'vision',
        'mission',
        'achievements',
        'photo',
        'organization_type',
        'facebook',
        'instagram',
        'twitter',
        'linkedin',
        'contact_email',
        'contact_phone',
        'order',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($organization) {
            if (empty($organization->slug)) {
                $organization->slug = Str::slug($organization->name);
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('name');
    }

    public function galleries()
    {
        return $this->hasMany(OrganizationGallery::class)->ordered();
    }

    public function featuredGalleries()
    {
        return $this->hasMany(OrganizationGallery::class)
            ->featured()
            ->ordered();
    }

    public function getPhotoUrlAttribute(): string
    {
        return $this->photo ? asset('storage/' . $this->photo) : asset('images/default-org.jpg');
    }

    public function getGalleryCountAttribute(): int
    {
        return $this->galleries()->count();
    }

    public function getRecentActivities($limit = 6)
    {
        return $this->galleries()
            ->orderBy('event_date', 'desc')
            ->take($limit)
            ->get();
    }

    public function getActivitiesByYear($year)
    {
        return $this->galleries()
            ->byYear($year)
            ->ordered()
            ->get();
    }

    public function getAvailableYears()
    {
        return $this->galleries()
            ->selectRaw('YEAR(event_date) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');
    }

    public function getEventTypes()
    {
        return $this->galleries()
            ->select('event_type')
            ->distinct()
            ->whereNotNull('event_type')
            ->pluck('event_type');
    }
}