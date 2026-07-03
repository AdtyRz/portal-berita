<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreVideoRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:videos,slug'],
            'description' => ['nullable', 'string', 'max:500'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'video_url' => ['required_unless:video_type,upload', 'nullable', 'string', 'max:500'],
            'video_type' => ['required', 'in:youtube,vimeo,upload'],
            'video_file' => ['nullable', 'file', 'mimes:mp4,mov,avi,webm', 'max:102400'],
            'duration' => ['nullable', 'integer', 'min:0'],
            'status' => ['required', 'in:draft,published,archived'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
        ];
    }
}
