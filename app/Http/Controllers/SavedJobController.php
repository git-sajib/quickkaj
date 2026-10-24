<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SavedJobController extends Controller
{
    public function index(): View
    {
        $savedJobs = auth()->user()
            ->savedJobs()
            ->with('category')
            ->orderByPivot('saved_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('jobs.saved', compact('savedJobs'));
    }

    /**
     * Toggle save state for a job. Returns JSON for AJAX or redirects for form posts.
     */
    public function toggle(Request $request, Job $job): JsonResponse|RedirectResponse
    {
        $user = auth()->user();

        if ($user->savedJobs()->where('job_id', $job->id)->exists()) {
            $user->savedJobs()->detach($job->id);
            $saved = false;
        } else {
            $user->savedJobs()->attach($job->id, ['saved_at' => now()]);
            $saved = true;
        }

        if ($request->wantsJson()) {
            return response()->json(['saved' => $saved]);
        }

        return back()->with('success',
            $saved
                ? (app()->getLocale() === 'bn' ? 'চাকরিটি সংরক্ষণ হয়েছে।' : 'Job saved.')
                : (app()->getLocale() === 'bn' ? 'চাকরিটি সরানো হয়েছে।' : 'Job removed from saved.')
        );
    }
}
