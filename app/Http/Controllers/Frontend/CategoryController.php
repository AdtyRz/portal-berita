<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function show(string $slug): View
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $posts = $category->publishedPosts()
            ->with('author', 'tags')
            ->latest('publish_date')
            ->paginate(12);

        return view('frontend.posts.index', compact('posts', 'category'));
    }
}
