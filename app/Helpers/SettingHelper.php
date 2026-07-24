<?php

namespace App\Helpers;

use App\Models\Setting;

class SettingHelper
{
    /**
     * Get setting value
     */
    public static function get(string $key, $default = null)
    {
        return Setting::get($key, $default);
    }

    /**
     * Set setting value
     */
    public static function set(string $key, $value, string $type = 'text', string $group = 'general', ?string $description = null)
    {
        return Setting::set($key, $value, $type, $group, $description);
    }

    /**
     * Get school profile settings
     */
    public static function getSchoolProfile(): array
    {
        return Setting::getByGroup('school_profile');
    }

    /**
     * Get principal message
     */
    public static function getPrincipalMessage(): array
    {
        return [
            'name' => Setting::get('principal_name', 'Principal Name'),
            'message' => Setting::get('principal_message', 'Welcome to our school.'),
            'photo' => Setting::get('principal_photo'),
        ];
    }
}
