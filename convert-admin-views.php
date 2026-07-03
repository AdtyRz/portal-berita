<?php

// Script v2: Lebih smart, hanya convert root level

$directory = 'resources/views/admin';
$files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($directory, RecursiveDirectoryIterator::SKIP_DOTS),
    RecursiveIteratorIterator::SELF_FIRST
);

foreach ($files as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $filepath = $file->getPathname();
        $content = file_get_contents($filepath);
        $originalContent = $content;
        
        // 1. Convert <x-admin.layouts.app> di awal file ke @extends + @section('content')
        $content = preg_replace(
            '/^<x-admin\.layouts\.app>\s*/m',
            "@extends('admin.layouts.app')\n\n@section('content')\n",
            $content
        );
        
        // 2. Convert </x-admin.layouts.app> di akhir file ke @endsection
        $content = preg_replace(
            '/\s*<\/x-admin\.layouts\.app>\s*$/m',
            "\n@endsection",
            $content
        );
        
        // 3. Convert <x-slot name="title">...</x-slot> (single line) ke @section('title', '...')
        $content = preg_replace(
            '/<x-slot name="title">(.*?)<\/x-slot>/s',
            "@section('title', '$1')",
            $content
        );
        
        // 4. Convert <x-slot name="pageHeader">...</x-slot> ke @section('pageHeader')...@endsection
        $content = preg_replace(
            '/<x-slot name="pageHeader">\s*(.*?)\s*<\/x-slot>/s',
            "@section('pageHeader')\n$1\n@endsection",
            $content
        );
        
        // JANGAN convert <x-slot name="head">, <x-slot name="action">, dll yang ada di dalam component
        // Biarkan tetap sebagai <x-slot> karena itu slot component, bukan section layout
        
        // Save jika ada perubahan
        if ($content !== $originalContent) {
            file_put_contents($filepath, $content);
            echo "Converted: $filepath\n";
        }
    }
}

echo "\nConversion complete!\n";