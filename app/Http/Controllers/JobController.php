<?php

namespace App\Http\Controllers;

use App\Models\AdPlacement;
use App\Models\Category;
use App\Models\Job;
use App\Models\PageView;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JobController extends Controller
{
    public function index(string $locale, Request $request): View
    {
        $filters = $request->only(['q', 'location', 'employment_type', 'education_level', 'category', 'deadline_within']);

        $jobs = Job::published()
            ->where('is_outdated', false)
            ->search($filters)
            ->with(['category'])
            ->orderByDesc('published_at')
            ->paginate(15)
            ->withQueryString();

        $categories = Category::orderBy('order')->get();

        $employmentTypes = [
            'full-time' => app()->getLocale() === 'bn' ? 'পূর্ণকালীন' : 'Full-time',
            'part-time' => app()->getLocale() === 'bn' ? 'খণ্ডকালীন' : 'Part-time',
            'contract' => app()->getLocale() === 'bn' ? 'চুক্তিভিত্তিক' : 'Contract',
            'internship' => app()->getLocale() === 'bn' ? 'ইন্টার্নশিপ' : 'Internship',
        ];

        $educationLevels = [
            'any' => app()->getLocale() === 'bn' ? 'যেকোনো' : 'Any',
            'ssc' => 'SSC',
            'hsc' => 'HSC',
            'graduate' => app()->getLocale() === 'bn' ? 'স্নাতক' : 'Graduate',
            'postgraduate' => app()->getLocale() === 'bn' ? 'স্নাতকোত্তর' : 'Postgraduate',
        ];

        $sidebarAd = AdPlacement::getSlot('sidebar-top');

        // Track page view (no personal data)
        PageView::record($request, 'jobs.index');

        return view('jobs.index', compact(
            'jobs', 'filters', 'categories',
            'employmentTypes', 'educationLevels', 'sidebarAd'
        ));
    }

    public function show(string $locale, string $slug, Request $request): View
    {
        $job = Job::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        $job->increment('views');

        $relatedJobs = Job::active()
            ->where('id', '!=', $job->id)
            ->when($job->category_id, fn ($q) => $q->where('category_id', $job->category_id))
            ->orderByDesc('published_at')
            ->limit(4)
            ->get();

        $inlineAd = AdPlacement::getSlot('article-inline');

        // Saved state for logged-in users
        $isSaved = auth()->check()
            ? $job->savedByUsers()->where('user_id', auth()->id())->exists()
            : false;

        PageView::record($request, 'jobs.show');

        return view('jobs.show', compact('job', 'relatedJobs', 'inlineAd', 'isSaved'));
    }
}
