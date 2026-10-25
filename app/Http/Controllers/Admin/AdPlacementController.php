<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdPlacement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdPlacementController extends Controller
{
    private const AVAILABLE_SLOTS = [
        'header-banner' => 'Header Banner (Above Navbar — 728×90)',
        'social-bar' => 'Social Bar / In-Page Push (Global Script — Highest CTR)',
        'tool-bottom' => 'Tools In-Page Banner / Native (High CTR — 728×90 / 300×250 / Native)',
        'popunder' => 'Popunder / OnClick Script (Highest eCPM / Global)',
        'sidebar-top' => 'Sidebar Top (300×250)',
        'article-inline' => 'Article / Job Inline (Native Ad)',
        'smartlink' => 'Adsterra Smartlink / Direct Link (High CTR Action Buttons)',
        'footer-banner' => 'Footer Banner (728×90)',
    ];

    public function index(): View
    {
        $adPlacements = AdPlacement::orderBy('slot_key')->get();

        return view('admin.ad-placements.index', compact('adPlacements'));
    }

    public function create(): View
    {
        $availableSlots = self::AVAILABLE_SLOTS;
        $usedSlots = AdPlacement::pluck('slot_key')->toArray();
        $remainingSlots = array_diff_key($availableSlots, array_flip($usedSlots));

        return view('admin.ad-placements.create', compact('remainingSlots'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'slot_key' => 'required|string|in:'.implode(',', array_keys(self::AVAILABLE_SLOTS)).'|unique:ad_placements,slot_key',
            'label' => 'required|string|max:100',
            'html_code' => 'nullable|string|max:5000',
            'is_active' => 'boolean',
        ]);

        AdPlacement::create($validated);

        return redirect()->route('admin.ad-placements.index')->with('success', 'বিজ্ঞাপন স্লট তৈরি হয়েছে।');
    }

    public function edit(AdPlacement $adPlacement): View
    {
        return view('admin.ad-placements.edit', compact('adPlacement'));
    }

    public function update(Request $request, AdPlacement $adPlacement): RedirectResponse
    {
        $validated = $request->validate([
            'label' => 'required|string|max:100',
            'html_code' => 'nullable|string|max:5000',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $adPlacement->update($validated);

        return redirect()->route('admin.ad-placements.index')->with('success', 'বিজ্ঞাপন স্লট আপডেট হয়েছে।');
    }

    public function destroy(AdPlacement $adPlacement): RedirectResponse
    {
        $adPlacement->delete();

        return redirect()->route('admin.ad-placements.index')->with('success', 'বিজ্ঞাপন স্লট মুছে ফেলা হয়েছে।');
    }
}
