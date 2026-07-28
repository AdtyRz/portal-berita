<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolProfile extends Model
{
    protected $fillable = [
        'name',
        'short_name',
        'tagline',
        'description',
        'vision',
        'mission',
        'address',
        'phone',
        'email',
        'website',
        'founded_year',
        'accreditation',
        'principal_name',
        
        // Social Media Links
        'facebook',
        'instagram',
        'twitter',
        'youtube',
        'linkedin',
        'tiktok',
        
    // Social Media Embed Codes
    'instagram_embed_1',
    'instagram_embed_2',
    'tiktok_embed_1',
    'tiktok_embed_2',
    'youtube_embed_1',
    'youtube_embed_2',
    'facebook_embed_1',
    'facebook_embed_2',
        
        // Branding
        'logo',
        'favicon',
        'cover_image',
    ];

    protected $casts = [
        'mission' => 'array',
    ];

    public static function getCurrent(): self
    {
        return cache()->remember('school_profile', 3600, function () {
            return self::first() ?? self::create([
                'name' => 'School Portal',
                'short_name' => 'SP',
                'tagline' => 'Excellence in Education',
                'description' => 'Providing quality education and fostering excellence in students.',
            ]);
        });
    }

    public static function clearCache(): void
    {
        cache()->forget('school_profile');
    }

    public function getLogoUrlAttribute(): ?string
    {
        return $this->logo ? asset('storage/' . $this->logo) : null;
    }

    public function getCoverUrlAttribute(): ?string
    {
        return $this->cover_image ? asset('storage/' . $this->cover_image) : null;
    }

    public function getMissionListAttribute(): array
    {
        if (is_array($this->mission)) {
            return $this->mission;
        }
        if (is_string($this->mission)) {
            return array_filter(array_map('trim', explode("\n", $this->mission)));
        }
        return [];
    }

    public function getSocialLinksAttribute(): array
    {
        return array_filter([
            'facebook' => $this->facebook,
            'instagram' => $this->instagram,
            'twitter' => $this->twitter,
            'youtube' => $this->youtube,
            'linkedin' => $this->linkedin,
            'tiktok' => $this->tiktok,
        ]);
    }
}