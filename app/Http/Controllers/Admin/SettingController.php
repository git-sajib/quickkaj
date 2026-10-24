<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\View\View;

class SettingController extends Controller
{
    private const SETTINGS = [
        'site_name_bn' => ['label' => 'সাইটের নাম (বাংলা)', 'group' => 'general'],
        'site_name_en' => ['label' => 'Site Name (English)', 'group' => 'general'],
        'site_tagline_bn' => ['label' => 'ট্যাগলাইন (বাংলা)', 'group' => 'general'],
        'site_tagline_en' => ['label' => 'Tagline (English)', 'group' => 'general'],
        'contact_email' => ['label' => 'Contact Email', 'group' => 'general'],
        'ga_tracking_id' => ['label' => 'Google Analytics ID', 'group' => 'analytics'],
        'facebook_url' => ['label' => 'Facebook URL', 'group' => 'social'],
        'twitter_url' => ['label' => 'Twitter URL', 'group' => 'social'],
        'youtube_url' => ['label' => 'YouTube URL', 'group' => 'social'],
        'telegram_url' => ['label' => 'Telegram Channel / Group URL', 'group' => 'social'],
        'whatsapp_url' => ['label' => 'WhatsApp Channel / Group URL', 'group' => 'social'],
        'footer_text_bn' => ['label' => 'ফুটার টেক্সট (বাংলা)', 'group' => 'general'],
        'footer_text_en' => ['label' => 'Footer Text (English)', 'group' => 'general'],
    ];

    public function index(): View
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        $settingDefinitions = self::SETTINGS;

        return view('admin.settings.index', compact('settings', 'settingDefinitions'));
    }

    public function update(Request $request): RedirectResponse
    {
        $allowed = array_keys(self::SETTINGS);

        foreach ($allowed as $key) {
            $value = $request->input($key);
            if ($value !== null) {
                Setting::setValue($key, strip_tags($value));
            }
        }

        return redirect()->route('admin.settings.index')->with('success', 'সেটিংস সংরক্ষণ হয়েছে।');
    }

    /**
     * Clear application compiled views and system cache.
     */
    public function clearCache(): RedirectResponse
    {
        Artisan::call('view:clear');
        Artisan::call('cache:clear');

        return redirect()->route('admin.settings.index')->with('success', 'ওয়েবসাইটের ভিউ এবং সিস্টেম ক্যাশ সফলভাবে ক্লিয়ার করা হয়েছে।');
    }
}
