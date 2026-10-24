<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Set application locale from the URL prefix (bn or en).
     * Falls back to config default locale if no prefix found.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $supportedLocales = ['bn', 'en'];
        $segment = $request->segment(1);

        $locale = in_array($segment, $supportedLocales)
            ? $segment
            : config('app.locale', 'bn');

        app()->setLocale($locale);
        view()->share('currentLocale', $locale);
        URL::defaults(['locale' => $locale]);

        return $next($request);
    }
}
