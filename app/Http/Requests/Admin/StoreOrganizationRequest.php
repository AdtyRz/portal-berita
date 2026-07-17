<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrganizationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:organizations,slug'],
            'position' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'vision' => ['nullable', 'string', 'max:2000'],
            'mission' => ['nullable', 'string', 'max:2000'],
            'achievements' => ['nullable', 'string', 'max:2000'],
            'organization_type' => ['nullable', 'string', 'max:50'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'facebook' => ['nullable', 'url', 'max:255'],
            'instagram' => ['nullable', 'url', 'max:255'],
            'twitter' => ['nullable', 'url', 'max:255'],
            'linkedin' => ['nullable', 'url', 'max:255'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:20'],
            'order' => ['nullable', 'integer', 'min:0'],
            'status' => ['required', 'boolean'],

            // Gallery uploads (optional)
            'gallery_images' => ['nullable', 'array'],
            'gallery_images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'gallery_titles' => ['nullable', 'array'],
            'gallery_titles.*' => ['string', 'max:255'],
            'gallery_descriptions' => ['nullable', 'array'],
            'gallery_descriptions.*' => ['string', 'max:1000'],
            'gallery_types' => ['nullable', 'array'],
            'gallery_types.*' => ['string', 'max:50'],
            'gallery_dates' => ['nullable', 'array'],
            'gallery_dates.*' => ['date'],
        ];
    }
}