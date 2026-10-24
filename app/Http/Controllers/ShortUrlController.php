<?php

namespace App\Http\Controllers;

use App\Models\ShortUrl;
use App\Models\ShortUrlClick;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ShortUrlController extends Controller
{
    public function index(): View
    {
        return view('shorturl.index');
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'url' => 'required|url|max:2048',
        ]);

        $originalUrl = $validated['url'];

        // Prevent circular shortening of own domain
        $ownDomain = parse_url(config('app.url'), PHP_URL_HOST);
        $targetDomain = parse_url($originalUrl, PHP_URL_HOST);

        if ($targetDomain === $ownDomain) {
            return response()->json(['error' => 'Cannot shorten URLs from this domain.'], 422);
        }

        // Check if URL already shortened in last 24h from same IP
        $ipHash = hash('sha256', $request->ip());
        $existing = ShortUrl::where('original_url', $originalUrl)
            ->where('ip_hash', $ipHash)
            ->where('created_at', '>=', now()->subDay())
            ->first();

        if ($existing) {
            return response()->json([
                'short_url' => route('shorturl.redirect', $existing->code),
                'code' => $existing->code,
                'clicks' => $existing->clicks,
            ]);
        }

        // Generate unique code
        do {
            $code = Str::random(7);
        } while (ShortUrl::where('code', $code)->exists());

        $shortUrl = ShortUrl::create([
            'code' => $code,
            'original_url' => $originalUrl,
            'ip_hash' => $ipHash,
            'is_active' => true,
        ]);

        return response()->json([
            'short_url' => route('shorturl.redirect', $shortUrl->code),
            'code' => $shortUrl->code,
            'clicks' => 0,
        ]);
    }

    public function redirect(string $code): RedirectResponse
    {
        $shortUrl = ShortUrl::where('code', $code)->firstOrFail();

        if (! $shortUrl->isAccessible()) {
            abort(410, 'This link is no longer active.');
        }

        // Log click
        ShortUrlClick::create([
            'short_url_id' => $shortUrl->id,
            'ip_hash' => hash('sha256', request()->ip()),
            'user_agent' => substr(request()->userAgent() ?? '', 0, 255),
            'referrer' => substr(request()->headers->get('referer') ?? '', 0, 500),
            'clicked_at' => now(),
        ]);

        $shortUrl->increment('clicks');

        // Safe redirect — no JS, no meta refresh trick
        return redirect()->away($shortUrl->original_url, 301);
    }
}
