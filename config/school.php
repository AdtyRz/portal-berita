<?php

return [
    'name' => env('SCHOOL_NAME', 'School Portal'),
    'tagline' => env('SCHOOL_TAGLINE', 'Excellence in Education'),
    'address' => env('SCHOOL_ADDRESS', ''),
    'phone' => env('SCHOOL_PHONE', ''),
    'email' => env('SCHOOL_EMAIL', ''),
    'website' => env('SCHOOL_WEBSITE', ''),

    'pagination' => [
        'news' => 12,
        'gallery' => 20,
        'videos' => 12,
    ],

    'upload' => [
        'max_size' => 5120, // 5MB
        'allowed_images' => ['jpg', 'jpeg', 'png', 'webp'],
        'allowed_documents' => ['pdf', 'doc', 'docx', 'xls', 'xlsx'],
    ],
];
