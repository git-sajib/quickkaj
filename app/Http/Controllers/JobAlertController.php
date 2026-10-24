<?php

namespace App\Http\Controllers;

use App\Models\JobAlert;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class JobAlertController extends Controller
{
    public function subscribe(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'keyword' => ['nullable', 'string', 'max:100'],
            'location' => ['nullable', 'string', 'max:100'],
        ]);

        JobAlert::subscribeEmail($request->email, [
            'keyword' => $request->keyword,
            'location' => $request->location,
        ]);

        return back()->with('success',
            app()->getLocale() === 'bn'
                ? 'জব অ্যালার্ট সাবস্ক্রাইব হয়েছে!'
                : 'Job alert subscription confirmed!'
        );
    }

    public function unsubscribe(string $token): RedirectResponse
    {
        $alert = JobAlert::where('unsubscribe_token', $token)->firstOrFail();
        $alert->update(['is_active' => false]);

        return redirect('/')->with('success',
            app()->getLocale() === 'bn'
                ? 'আপনাকে জব অ্যালার্ট থেকে বাদ দেওয়া হয়েছে।'
                : 'You have been unsubscribed from job alerts.'
        );
    }
}
