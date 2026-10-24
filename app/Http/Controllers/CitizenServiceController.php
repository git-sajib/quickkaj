<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class CitizenServiceController extends Controller
{
    /**
     * Main citizen services & result hub.
     */
    public function index(Request $request): View
    {
        return view('citizen.index');
    }

    /**
     * E-Passport application and fee guide.
     */
    public function passport(): View
    {
        return view('citizen.passport');
    }

    /**
     * NID and birth registration guide.
     */
    public function nid(): View
    {
        return view('citizen.nid');
    }

    /**
     * Exam result SMS generator & notice tracker.
     */
    public function results(): View
    {
        return view('citizen.results');
    }

    /**
     * Ready-to-use GD & official application draft formats.
     */
    public function applications(): View
    {
        return view('citizen.applications');
    }
}
