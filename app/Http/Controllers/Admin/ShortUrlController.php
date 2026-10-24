<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShortUrl;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ShortUrlController extends Controller
{
    public function index(): View
    {
        $shortUrls = ShortUrl::orderByDesc('created_at')->paginate(20)->withQueryString();

        return view('admin.short-urls.index', compact('shortUrls'));
    }

    public function show(ShortUrl $shortUrl): View
    {
        $shortUrl->load('clickLogs');

        return view('admin.short-urls.show', compact('shortUrl'));
    }

    public function destroy(ShortUrl $shortUrl): RedirectResponse
    {
        $shortUrl->clickLogs()->delete();
        $shortUrl->delete();

        return redirect()->route('admin.short-urls.index')->with('success', 'URL মুছে ফেলা হয়েছে।');
    }

    public function toggle(ShortUrl $shortUrl): RedirectResponse
    {
        $shortUrl->update(['is_active' => ! $shortUrl->is_active]);
        $status = $shortUrl->is_active ? 'সক্রিয়' : 'নিষ্ক্রিয়';

        return redirect()->route('admin.short-urls.index')->with('success', "URL {$status} করা হয়েছে।");
    }
}
