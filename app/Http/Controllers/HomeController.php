<?php

namespace App\Http\Controllers;

use App\Models\AdPlacement;
use App\Models\Article;
use App\Models\Job;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(string $locale): View
    {
        $featuredJobs = Job::active()
            ->orderByDesc('published_at')
            ->limit(6)
            ->get();

        $latestArticles = Article::published()
            ->with(['category', 'author'])
            ->orderByDesc('published_at')
            ->limit(6)
            ->get();

        $featuredArticles = Article::published()
            ->featured()
            ->with(['category'])
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        $headerAd = AdPlacement::getSlot('header-banner');
        $sidebarAd = AdPlacement::getSlot('sidebar-top');

        return view('home', compact(
            'featuredJobs',
            'latestArticles',
            'featuredArticles',
            'headerAd',
            'sidebarAd'
        ));
    }
}
