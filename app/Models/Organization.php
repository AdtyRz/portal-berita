<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Organization extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'description', 'logo', 'photo', 'position',
        'organization_type', 'order', 'status',
        'facebook', 'instagram', 'twitter', 'linkedin',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    protected $appends = ['social_links'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($org) {
            if (empty($org->slug)) {
                $org->slug = Str::slug($org->name);
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('name');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('organization_type', $type);
    }

    public function getLogoUrlAttribute(): string
    {
        return $this->logo ? asset('storage/' . $this->logo) : asset('images/default-avatar.png');
    }

    public function getPhotoUrlAttribute(): string
    {
        return $this->photo ? asset('storage/' . $this->photo) : asset('images/default-avatar.png');
    }

    public function getSocialLinksAttribute(): array
    {
        return collect([
            'facebook' => $this->facebook,
            'instagram' => $this->instagram,
            'twitter' => $this->twitter,
            'linkedin' => $this->linkedin,
        ])->filter()->toArray();
    }
}
