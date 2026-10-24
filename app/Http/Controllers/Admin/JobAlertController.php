<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobAlert;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class JobAlertController extends Controller
{
    /**
     * Display a listing of job alert subscribers.
     */
    public function index(Request $request): View
    {
        $query = JobAlert::query();

        // Status filter
        $status = $request->input('status', 'all');
        if ($status === 'active') {
            $query->where('is_active', true);
        } elseif ($status === 'inactive') {
            $query->where('is_active', false);
        }

        // Search query
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('email', 'like', "%{$search}%")
                    ->orWhere('keyword', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });
        }

        $subscribers = $query->orderByDesc('created_at')->paginate(20)->withQueryString();

        $totalCount = JobAlert::count();
        $activeCount = JobAlert::where('is_active', true)->count();
        $inactiveCount = JobAlert::where('is_active', false)->count();

        return view('admin.job-alerts.index', compact(
            'subscribers',
            'status',
            'search',
            'totalCount',
            'activeCount',
            'inactiveCount'
        ));
    }

    /**
     * Toggle subscriber active status.
     */
    public function toggle(JobAlert $jobAlert): RedirectResponse
    {
        $jobAlert->update([
            'is_active' => ! $jobAlert->is_active,
        ]);

        $statusText = $jobAlert->is_active ? 'সক্রিয় (Active)' : 'নিষ্ক্রিয় (Inactive)';

        return back()->with('success', "গ্রাহকের স্ট্যাটাস {$statusText} করা হয়েছে।");
    }

    /**
     * Export all subscribers as a CSV file.
     */
    public function exportCsv(): StreamedResponse
    {
        $fileName = 'quickkaj-job-alerts-subscribers-'.now()->format('Y-m-d').'.csv';

        return response()->streamDownload(function () {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Email', 'Keyword', 'Location', 'Employment Type', 'Status', 'Subscribed At']);

            JobAlert::orderByDesc('created_at')->chunk(200, function ($subscribers) use ($handle) {
                foreach ($subscribers as $sub) {
                    fputcsv($handle, [
                        $sub->id,
                        $sub->email,
                        $sub->keyword ?? '',
                        $sub->location ?? '',
                        $sub->employment_type ?? '',
                        $sub->is_active ? 'Active' : 'Unsubscribed',
                        $sub->created_at->format('Y-m-d H:i:s'),
                    ]);
                }
            });

            fclose($handle);
        }, $fileName, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
        ]);
    }

    /**
     * Remove the specified subscriber.
     */
    public function destroy(JobAlert $jobAlert): RedirectResponse
    {
        $jobAlert->delete();

        return back()->with('success', 'গ্রাহক সফলভাবে মুছে ফেলা হয়েছে।');
    }
}
