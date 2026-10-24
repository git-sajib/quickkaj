<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::with('parent')->orderBy('order')->paginate(20)->withQueryString();

        return view('admin.categories.index', compact('categories'));
    }

    public function create(): View
    {
        $parentCategories = Category::whereNull('parent_id')->orderBy('name_bn')->get();

        return view('admin.categories.create', compact('parentCategories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name_bn' => 'required|string|max:100',
            'name_en' => 'nullable|string|max:100',
            'description_bn' => 'nullable|string',
            'description_en' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'parent_id' => 'nullable|exists:categories,id',
            'order' => 'nullable|integer|min:0',
        ]);

        $validated['slug'] = Str::slug($validated['name_en'] ?? $validated['name_bn']) ?: 'cat-'.Str::random(6);

        Category::create($validated);

        return redirect()->route('admin.categories.index')->with('success', 'বিভাগ তৈরি হয়েছে।');
    }

    public function edit(Category $category): View
    {
        $parentCategories = Category::whereNull('parent_id')->where('id', '!=', $category->id)->orderBy('name_bn')->get();

        return view('admin.categories.edit', compact('category', 'parentCategories'));
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $validated = $request->validate([
            'name_bn' => 'required|string|max:100',
            'name_en' => 'nullable|string|max:100',
            'description_bn' => 'nullable|string',
            'description_en' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'parent_id' => 'nullable|exists:categories,id',
            'order' => 'nullable|integer|min:0',
        ]);

        $category->update($validated);

        return redirect()->route('admin.categories.index')->with('success', 'বিভাগ আপডেট হয়েছে।');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'বিভাগ মুছে ফেলা হয়েছে।');
    }
}
