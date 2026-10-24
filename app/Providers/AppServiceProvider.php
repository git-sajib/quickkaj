<?php

namespace App\Providers;

use App\Models\AdPlacement;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share ad slots globally with the main layout and all views that extend it.
        // Uses a single DB query cached in the request lifecycle.
        View::composer('layouts.app', function (\Illuminate\View\View $view): void {
            $view->with([
                'headerAd' => AdPlacement::getSlot('header-banner'),
                'sidebarAd' => AdPlacement::getSlot('sidebar-top'),
                'socialBarAd' => AdPlacement::getSlot('social-bar'),
                'toolAd' => AdPlacement::getSlot('tool-bottom'),
            ]);
        });

        // Register custom Tailwind pagination as application-wide default
        Paginator::defaultView('vendor.pagination.tailwind');

        // Set default locale for URL generation across all routes
        URL::defaults(['locale' => config('app.locale', 'bn')]);
    }
}
