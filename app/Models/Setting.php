<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'type', 'group', 'description'];

    /**
     * Get setting value (dengan Cache agar cepat)
     */
    public static function get(string $key, $default = null)
    {
        return Cache::remember("setting_{$key}", 3600, function () use ($key, $default) {
            $setting = static::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    /**
     * Set setting value
     */
    public static function set(string $key, $value, string $type = 'text', string $group = 'general', ?string $description = null): void
    {
        static::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value, 
                'type' => $type, 
                'group' => $group,
                'description' => $description
            ]
        );
        
        // Hapus cache agar data baru langsung terbaca
        Cache::forget("setting_{$key}");
        Cache::forget("settings_group_{$group}");
    }

    /**
     * Get all settings by group
     */
    public static function getGroup(string $group): array
    {
        return Cache::remember("settings_group_{$group}", 3600, function () use ($group) {
            return static::where('group', $group)
                ->pluck('value', 'key')
                ->toArray();
        });
    }

    public static function clearCache(): void
    {
        $settings = static::all();
        foreach ($settings as $setting) {
            Cache::forget("setting_{$setting->key}");
        }
        
        $groups = static::pluck('group')->unique();
        foreach ($groups as $group) {
            Cache::forget("settings_group_{$group}");
        }
        
        Cache::forget('school_profile');
    }

    public function scopeByGroup($query, string $group)
    {
        return $query->where('group', $group);
    }
}