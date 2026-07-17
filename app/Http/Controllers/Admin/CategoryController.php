<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Models\ActivityLog;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('can:view-categories')->only(['index', 'show']);
    //     $this->middleware('can:create-categories')->only(['create', 'store']);
    //     $this->middleware('can:edit-categories')->only(['edit', 'update']);
    //     $this->middleware('can:delete-categories')->only(['destroy']);
    // }

    public function index(Request $request): View
    {
        $query = Category::query();

        // Search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('slug', 'like', "%{$request->search}%")
                  ->orWhere('description', 'like', "%{$request->search}%");
            });
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status === 'active');
        }

        // Sort
        $sortBy = $request->get('sort', 'order');
        $sortDir = $request->get('dir', 'asc');
        $query->orderBy($sortBy, $sortDir);

        $categories = $query->paginate(15)->withQueryString();

        return view('admin.categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('admin.categories.create');
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $category = Category::create($request->validated());

        ActivityLog::log('created', $category, "Created category: {$category->name}");

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function edit(Category $category): View
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        $category->update($request->validated());

        ActivityLog::log('updated', $category, "Updated category: {$category->name}");

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $name = $category->name;
        $category->delete();

        ActivityLog::log('deleted', $category, "Deleted category: {$name}");

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}
