<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdPlacement;
use App\Models\Article;
use App\Models\ContactMessage;
use App\Models\Job;
use App\Models\JobAlert;
use App\Models\PageView;
use App\Models\ShortUrl;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'jobs_total' => Job::count(),
            'jobs_published' => Job::where('is_published', true)->count(),
            'articles_total' => Article::count(),
            'articles_published' => Article::where('is_published', true)->count(),
            'short_urls_total' => ShortUrl::count(),
            'short_urls_clicks' => ShortUrl::sum('clicks'),
            'users_total' => User::count(),
            'ads_active' => AdPlacement::where('is_active', true)->count(),
            'unread_messages' => ContactMessage::where('is_read', false)->count(),
            'job_alerts_total' => JobAlert::where('is_active', true)->count(),
        ];

        $recentJobs = Job::orderByDesc('created_at')->limit(5)->get();
        $recentArticles = Article::orderByDesc('created_at')->limit(5)->get();
        $topPages = PageView::topPages(7, 5);

        return view('admin.dashboard', compact('stats', 'recentJobs', 'recentArticles', 'topPages'));
    }
}
