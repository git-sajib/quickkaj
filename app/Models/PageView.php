<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class PageView extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'url',
        'route_name',
        'referrer',
        'device_type',
        'country',
        'viewed_at',
    ];

    protected $casts = [
        'viewed_at' => 'datetime',
    ];

    /**
     * Record a page view. Detects device type from User-Agent header.
     * Stores no personally identifiable information.
     */
    public static function record(Request $request, ?string $routeName = null): void
    {
        try {
            $ua = strtolower($request->userAgent() ?? '');

            if (str_contains($ua, 'mobile') || str_contains($ua, 'android')) {
                $device = 'mobile';
            } elseif (str_contains($ua, 'tablet') || str_contains($ua, 'ipad')) {
                $device = 'tablet';
            } else {
                $device = 'desktop';
            }

            static::create([
                'url' => substr($request->path(), 0, 500),
                'route_name' => $routeName,
                'referrer' => substr($request->header('referer', ''), 0, 500) ?: null,
                'device_type' => $device,
                'viewed_at' => now(),
            ]);
        } catch (\Throwable) {
            // Never let analytics break the main request
        }
    }

    /* ─── Analytics helpers ─────────────────────────────────────────── */

    public static function topPages(int $days = 30, int $limit = 10): array
    {
        return static::query()
            ->where('viewed_at', '>=', now()->subDays($days))
            ->selectRaw('url, COUNT(*) as total')
            ->groupBy('url')
            ->orderByDesc('total')
            ->limit($limit)
            ->pluck('total', 'url')
            ->toArray();
    }

    public static function dailyTrend(int $days = 14): array
    {
        return static::query()
            ->where('viewed_at', '>=', now()->subDays($days))
            ->selectRaw('DATE(viewed_at) as date, COUNT(*) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date')
            ->toArray();
    }

    public static function deviceBreakdown(int $days = 30): array
    {
        return static::query()
            ->where('viewed_at', '>=', now()->subDays($days))
            ->selectRaw('device_type, COUNT(*) as total')
            ->groupBy('device_type')
            ->orderByDesc('total')
            ->pluck('total', 'device_type')
            ->toArray();
    }

    public static function topReferrers(int $days = 30, int $limit = 10): array
    {
        return static::query()
            ->where('viewed_at', '>=', now()->subDays($days))
            ->whereNotNull('referrer')
            ->selectRaw('referrer, COUNT(*) as total')
            ->groupBy('referrer')
            ->orderByDesc('total')
            ->limit($limit)
            ->pluck('total', 'referrer')
            ->toArray();
    }
}
