<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TagController extends Controller
{
    public function index(): View
    {
        $tags = Tag::withCount('articles')->orderBy('name_bn')->paginate(30)->withQueryString();

        return view('admin.tags.index', compact('tags'));
    }

    public function create(): View
    {
        return view('admin.tags.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name_bn' => 'required|string|max:60|unique:tags,name_bn',
            'name_en' => 'nullable|string|max:60',
        ]);

        $validated['slug'] = Str::slug($validated['name_en'] ?? $validated['name_bn']) ?: 'tag-'.Str::random(6);

        Tag::create($validated);

        return redirect()->route('admin.tags.index')->with('success', 'ট্যাগ তৈরি হয়েছে।');
    }

    public function edit(Tag $tag): View
    {
        return view('admin.tags.edit', compact('tag'));
    }

    public function update(Request $request, Tag $tag): RedirectResponse
    {
        $validated = $request->validate([
            'name_bn' => 'required|string|max:60|unique:tags,name_bn,'.$tag->id,
            'name_en' => 'nullable|string|max:60',
        ]);

        $tag->update($validated);

        return redirect()->route('admin.tags.index')->with('success', 'ট্যাগ আপডেট হয়েছে।');
    }

    public function destroy(Tag $tag): RedirectResponse
    {
        $tag->articles()->detach();
        $tag->delete();

        return redirect()->route('admin.tags.index')->with('success', 'ট্যাগ মুছে ফেলা হয়েছে।');
    }
}
