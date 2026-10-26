<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreJobRequest;
use App\Http\Requests\UpdateJobRequest;
use App\Models\Job;
use App\Services\OneSignalService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class JobController extends Controller
{
    public function index(Request $request): View
    {
        $query = Job::query();

        // Status filter
        $status = $request->input('status', 'all');
        if ($status === 'published') {
            $query->where('is_published', true);
        } elseif ($status === 'draft') {
            $query->where('is_published', false);
        } elseif ($status === 'expired') {
            $query->where('deadline', '<', now()->startOfDay());
        }

        // Search query
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title_bn', 'like', "%{$search}%")
                    ->orWhere('title_en', 'like', "%{$search}%")
                    ->orWhere('employer_bn', 'like', "%{$search}%")
                    ->orWhere('employer_en', 'like', "%{$search}%");
            });
        }

        $jobs = $query->orderByDesc('created_at')->paginate(20)->withQueryString();

        $totalCount = Job::count();
        $publishedCount = Job::where('is_published', true)->count();
        $draftCount = Job::where('is_published', false)->count();
        $expiredCount = Job::where('deadline', '<', now()->startOfDay())->count();

        return view('admin.jobs.index', compact(
            'jobs',
            'search',
            'status',
            'totalCount',
            'publishedCount',
            'draftCount',
            'expiredCount'
        ));
    }

    public function create(): View
    {
        return view('admin.jobs.create');
    }

    public function store(StoreJobRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = $this->generateSlug($data['title_bn']);
        $data['created_by'] = auth()->id();

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')
                ->store('jobs', 'public');
        }

        if ($request->hasFile('circular_pdf')) {
            $data['circular_pdf'] = $request->file('circular_pdf')
                ->store('jobs/circulars', 'public');
        }

        if ($data['is_published'] ?? false) {
            $data['published_at'] = now();
        }

        $job = Job::create($data);

        // OneSignal Web Push Notification
        if (($data['is_published'] ?? false) && $request->boolean('send_push')) {
            $pushTitle = 'নতুন চাকরির বিজ্ঞপ্তি: '.$job->title_bn;
            $pushMsg = ($job->employer_bn ? $job->employer_bn.' — ' : '').'বিস্তারিত দেখুন ও আবেদন করুন।';
            $jobUrl = url('/bn/jobs/'.$job->slug);
            $imgUrl = $job->featured_image ? asset('storage/'.$job->featured_image) : null;

            OneSignalService::sendPush($pushTitle, $pushMsg, $jobUrl, $imgUrl);
        }

        return redirect()->route('admin.jobs.index')->with('success', 'চাকরি সফলভাবে তৈরি হয়েছে এবং নোটিফিকেশন পাঠানো হয়েছে।');
    }

    public function edit(Job $job): View
    {
        return view('admin.jobs.edit', compact('job'));
    }

    public function update(UpdateJobRequest $request, Job $job): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('featured_image')) {
            if ($job->featured_image) {
                Storage::disk('public')->delete($job->featured_image);
            }
            $data['featured_image'] = $request->file('featured_image')
                ->store('jobs', 'public');
        }

        if ($request->hasFile('circular_pdf')) {
            if ($job->circular_pdf) {
                Storage::disk('public')->delete($job->circular_pdf);
            }
            $data['circular_pdf'] = $request->file('circular_pdf')
                ->store('jobs/circulars', 'public');
        } elseif ($request->boolean('remove_circular_pdf')) {
            if ($job->circular_pdf) {
                Storage::disk('public')->delete($job->circular_pdf);
            }
            $data['circular_pdf'] = null;
        }

        if (($data['is_published'] ?? false) && ! $job->published_at) {
            $data['published_at'] = now();
        } elseif (! ($data['is_published'] ?? false)) {
            $data['published_at'] = null;
        }

        $job->update($data);

        return redirect()->route('admin.jobs.index')->with('success', 'চাকরি সফলভাবে আপডেট হয়েছে।');
    }

    public function destroy(Job $job): RedirectResponse
    {
        if ($job->circular_pdf) {
            Storage::disk('public')->delete($job->circular_pdf);
        }
        if ($job->featured_image) {
            Storage::disk('public')->delete($job->featured_image);
        }

        $job->delete();

        return redirect()->route('admin.jobs.index')->with('success', 'চাকরি মুছে ফেলা হয়েছে।');
    }

    private function generateSlug(string $title): string
    {
        $slug = Str::slug($title);
        if (empty($slug)) {
            $slug = 'job-'.Str::random(8);
        }

        $count = Job::where('slug', 'like', $slug.'%')->count();

        return $count > 0 ? $slug.'-'.($count + 1) : $slug;
    }
}
