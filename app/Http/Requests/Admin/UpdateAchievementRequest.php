<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAchievementRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('achievements')->ignore($this->achievement)],
            'description' => ['nullable', 'string', 'max:500'],
            'content' => ['nullable', 'string'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'achievement_type' => ['nullable', 'string', 'max:100'],
            'achiever_name' => ['nullable', 'string', 'max:255'],
            'competition_name' => ['nullable', 'string', 'max:255'],
            'level' => ['required', 'in:school,district,city,province,national,international'],
            'rank' => ['nullable', 'in:1st,2nd,3rd,honorable,participant'],
            'achievement_date' => ['nullable', 'date'],
            'status' => ['required', 'in:draft,published,archived'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
        ];
    }
}
