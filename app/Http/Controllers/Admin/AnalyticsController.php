<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Job;
use App\Models\PageView;
use App\Models\ShortUrl;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AnalyticsController extends Controller
{
    public function index(Request $request): View
    {
        $days = (int) $request->get('days', 30);
        $days = in_array($days, [7, 14, 30, 90]) ? $days : 30;

        $topPages = PageView::topPages($days, 15);
        $dailyTrend = PageView::dailyTrend($days);
        $deviceBreakdown = PageView::deviceBreakdown($days);
        $topReferrers = PageView::topReferrers($days, 10);

        $totalViews = array_sum($dailyTrend);
        $todayViews = PageView::whereDate('viewed_at', today())->count();

        // Content stats
        $totalJobs = Job::published()->count();
        $activeJobs = Job::active()->count();
        $totalArticles = Article::published()->count();
        $totalUrls = ShortUrl::count();

        // Top content by views
        $topJobs = Job::published()->orderByDesc('views')->limit(5)->get();
        $topArticles = Article::published()->orderByDesc('views')->limit(5)->get();

        return view('admin.analytics.index', compact(
            'days', 'topPages', 'dailyTrend', 'deviceBreakdown', 'topReferrers',
            'totalViews', 'todayViews',
            'totalJobs', 'activeJobs', 'totalArticles', 'totalUrls',
            'topJobs', 'topArticles'
        ));
    }
}
