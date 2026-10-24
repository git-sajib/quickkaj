<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CitizenServiceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobAlertController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SavedJobController;
use App\Http\Controllers\ShortUrlController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\ToolController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Root redirect to default locale
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('home', ['locale' => config('app.locale', 'bn')]);
});

/*
|--------------------------------------------------------------------------
| Bilingual public routes /{locale}/...
|--------------------------------------------------------------------------
*/
Route::prefix('{locale}')
    ->where(['locale' => 'bn|en'])
    ->middleware('setlocale')
    ->group(function () {

        // Home
        Route::get('/', [HomeController::class, 'index'])->name('home');

        // Jobs Portal
        Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
        Route::get('/jobs/{slug}', [JobController::class, 'show'])->name('jobs.show');

        // News & Articles
        Route::get('/news', [ArticleController::class, 'index'])->name('articles.index');
        Route::get('/news/category/{slug}', [ArticleController::class, 'category'])->name('articles.category');
        Route::get('/news/{slug}', [ArticleController::class, 'show'])->name('articles.show');

        // Tools Portal (Bilingual /bn/tools/... and /en/tools/...)
        Route::get('/tools', [ToolController::class, 'index'])->name('tools.index');
        Route::get('/tools/word-counter', [ToolController::class, 'wordCounter'])->name('tools.word-counter');
        Route::get('/tools/case-converter', [ToolController::class, 'caseConverter'])->name('tools.case-converter');
        Route::get('/tools/json-formatter', [ToolController::class, 'jsonFormatter'])->name('tools.json-formatter');
        Route::get('/tools/url-encoder', [ToolController::class, 'urlEncoder'])->name('tools.url-encoder');
        Route::get('/tools/qr-generator', [ToolController::class, 'qrGenerator'])->name('tools.qr-generator');
        Route::get('/tools/password-generator', [ToolController::class, 'passwordGenerator'])->name('tools.password-generator');
        Route::get('/tools/image-compressor', [ToolController::class, 'imageCompressor'])->name('tools.image-compressor');
        Route::get('/tools/image-resizer', [ToolController::class, 'imageResizer'])->name('tools.image-resizer');
        Route::get('/tools/image-converter', [ToolController::class, 'imageConverter'])->name('tools.image-converter');
        Route::get('/tools/background-remover', [ToolController::class, 'backgroundRemover'])->name('tools.background-remover');
        Route::get('/tools/age-calculator', [ToolController::class, 'ageCalculator'])->name('tools.age-calculator');
        Route::get('/tools/bmi-calculator', [ToolController::class, 'bmiCalculator'])->name('tools.bmi-calculator');
        Route::get('/tools/cgpa-calculator', [ToolController::class, 'cgpaCalculator'])->name('tools.cgpa-calculator');
        Route::get('/tools/salary-calculator', [ToolController::class, 'salaryCalculator'])->name('tools.salary-calculator');
        Route::get('/tools/unit-converter', [ToolController::class, 'unitConverter'])->name('tools.unit-converter');
        Route::get('/tools/cv-builder', [ToolController::class, 'cvBuilder'])->name('tools.cv-builder');
        Route::get('/tools/pdf-tools', [ToolController::class, 'pdfTools'])->name('tools.pdf-tools');

        // Citizen Services & Examination Results Hub
        Route::get('/services', [CitizenServiceController::class, 'index'])->name('citizen.index');
        Route::get('/services/passport-guide', [CitizenServiceController::class, 'passport'])->name('citizen.passport');
        Route::get('/services/nid-guide', [CitizenServiceController::class, 'nid'])->name('citizen.nid');
        Route::get('/services/exam-results', [CitizenServiceController::class, 'results'])->name('citizen.results');
        Route::get('/services/applications-gd', [CitizenServiceController::class, 'applications'])->name('citizen.applications');

        // Company & Information Pages
        Route::get('/about', [PageController::class, 'about'])->name('page.about');
        Route::get('/contact', [PageController::class, 'contact'])->name('page.contact');
        Route::post('/contact', [PageController::class, 'submitContact'])->name('page.contact.submit')->middleware('throttle:5,1');
        Route::get('/privacy-policy', [PageController::class, 'privacy'])->name('page.privacy');
        Route::get('/terms-of-use', [PageController::class, 'terms'])->name('page.terms');
    });

/*
|--------------------------------------------------------------------------
| Unprefixed Tool Routes (Backward compatibility & tests)
|--------------------------------------------------------------------------
*/
Route::middleware('setlocale')->group(function () {
    Route::get('/tools', [ToolController::class, 'index']);
    Route::get('/tools/word-counter', [ToolController::class, 'wordCounter']);
    Route::get('/tools/case-converter', [ToolController::class, 'caseConverter']);
    Route::get('/tools/json-formatter', [ToolController::class, 'jsonFormatter']);
    Route::get('/tools/url-encoder', [ToolController::class, 'urlEncoder']);
    Route::get('/tools/qr-generator', [ToolController::class, 'qrGenerator']);
    Route::get('/tools/password-generator', [ToolController::class, 'passwordGenerator']);
    Route::get('/tools/image-compressor', [ToolController::class, 'imageCompressor']);
    Route::get('/tools/image-resizer', [ToolController::class, 'imageResizer']);
    Route::get('/tools/image-converter', [ToolController::class, 'imageConverter']);
    Route::get('/tools/background-remover', [ToolController::class, 'backgroundRemover']);
    Route::get('/tools/age-calculator', [ToolController::class, 'ageCalculator']);
    Route::get('/tools/bmi-calculator', [ToolController::class, 'bmiCalculator']);
    Route::get('/tools/cgpa-calculator', [ToolController::class, 'cgpaCalculator']);
    Route::get('/tools/salary-calculator', [ToolController::class, 'salaryCalculator']);
    Route::get('/tools/unit-converter', [ToolController::class, 'unitConverter']);
    Route::get('/tools/cv-builder', [ToolController::class, 'cvBuilder']);
    Route::get('/tools/pdf-tools', [ToolController::class, 'pdfTools']);
});

// QR code API endpoint (server-side generation)
Route::post('/tools/qr-generator/generate', [ToolController::class, 'generateQr'])
    ->name('tools.qr-generator.generate')
    ->middleware('throttle:20,1');

/*
|--------------------------------------------------------------------------
| URL Shortener
|--------------------------------------------------------------------------
*/
Route::get('/shorten', [ShortUrlController::class, 'index'])->name('shorturl.index');
Route::post('/shorten', [ShortUrlController::class, 'store'])
    ->name('shorturl.store')
    ->middleware('throttle:10,1');
Route::get('/go/{code}', [ShortUrlController::class, 'redirect'])->name('shorturl.redirect');

/*
|--------------------------------------------------------------------------
| SEO routes
|--------------------------------------------------------------------------
*/
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/robots.txt', [SitemapController::class, 'robots'])->name('robots');

/*
|--------------------------------------------------------------------------
| Static Pages (Terms, Privacy)
|--------------------------------------------------------------------------
*/
Route::get('/about', fn () => redirect()->route('page.about', ['locale' => app()->getLocale()]));
Route::get('/contact', fn () => redirect()->route('page.contact', ['locale' => app()->getLocale()]));
Route::get('/privacy-policy', fn () => redirect()->route('page.privacy', ['locale' => app()->getLocale()]));
Route::get('/terms-of-use', fn () => redirect()->route('page.terms', ['locale' => app()->getLocale()]));
Route::get('/services', fn () => redirect()->route('citizen.index', ['locale' => app()->getLocale()]));
Route::get('/services/passport-guide', fn () => redirect()->route('citizen.passport', ['locale' => app()->getLocale()]));
Route::get('/services/nid-guide', fn () => redirect()->route('citizen.nid', ['locale' => app()->getLocale()]));
Route::get('/services/exam-results', fn () => redirect()->route('citizen.results', ['locale' => app()->getLocale()]));
Route::get('/services/applications-gd', fn () => redirect()->route('citizen.applications', ['locale' => app()->getLocale()]));

/*
|--------------------------------------------------------------------------
| Job Alerts (public subscribe, token-based unsubscribe)
|--------------------------------------------------------------------------
*/
Route::post('/job-alerts/subscribe', [JobAlertController::class, 'subscribe'])
    ->name('job-alerts.subscribe')
    ->middleware('throttle:5,1');
Route::get('/job-alerts/unsubscribe/{token}', [JobAlertController::class, 'unsubscribe'])
    ->name('job-alerts.unsubscribe');

/*
|--------------------------------------------------------------------------
| Saved Jobs (requires auth)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::post('/jobs/{job}/save', [SavedJobController::class, 'toggle'])
        ->name('jobs.save');
    Route::get('/saved-jobs', [SavedJobController::class, 'index'])
        ->name('saved-jobs.index');
    Route::get('/jobs-saved', [SavedJobController::class, 'index'])
        ->name('jobs.saved');
});

// Auth default redirect alias
Route::get('/dashboard', function () {
    return auth()->user()?->role === 'admin'
        ? redirect()->route('admin.dashboard')
        : redirect()->route('home', ['locale' => 'bn']);
})->middleware(['auth'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Admin Dashboard (auth + admin role required)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->name('admin.')
    ->group(function () {
        Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

        // Jobs
        Route::resource('jobs', Admin\JobController::class);

        // Articles
        Route::resource('articles', Admin\ArticleController::class);

        // Categories
        Route::resource('categories', Admin\CategoryController::class);

        // Tags
        Route::resource('tags', Admin\TagController::class);

        // Short URLs
        Route::resource('short-urls', Admin\ShortUrlController::class)->except(['edit', 'update']);
        Route::patch('short-urls/{short_url}/toggle', [Admin\ShortUrlController::class, 'toggle'])->name('short-urls.toggle');

        // Ad Placements
        Route::resource('ad-placements', Admin\AdPlacementController::class);

        // Settings
        Route::get('settings', [Admin\SettingController::class, 'index'])->name('settings.index');
        Route::post('settings', [Admin\SettingController::class, 'update'])->name('settings.update');

        // Users
        Route::resource('users', Admin\UserController::class)->except(['create', 'store']);

        // Analytics
        Route::get('analytics', [Admin\AnalyticsController::class, 'index'])->name('analytics.index');

        // Contact Messages
        Route::get('contact-messages', [Admin\ContactMessageController::class, 'index'])->name('contact-messages.index');
        Route::get('contact-messages/{contact_message}', [Admin\ContactMessageController::class, 'show'])->name('contact-messages.show');
        Route::patch('contact-messages/{contact_message}/toggle-read', [Admin\ContactMessageController::class, 'toggleRead'])->name('contact-messages.toggle-read');
        Route::delete('contact-messages/{contact_message}', [Admin\ContactMessageController::class, 'destroy'])->name('contact-messages.destroy');

        // Job Alerts Subscribers
        Route::get('job-alerts', [Admin\JobAlertController::class, 'index'])->name('job-alerts.index');
        Route::get('job-alerts/export', [Admin\JobAlertController::class, 'exportCsv'])->name('job-alerts.export');
        Route::patch('job-alerts/{job_alert}/toggle', [Admin\JobAlertController::class, 'toggle'])->name('job-alerts.toggle');
        Route::delete('job-alerts/{job_alert}', [Admin\JobAlertController::class, 'destroy'])->name('job-alerts.destroy');

        // Cache Management
        Route::post('clear-cache', [Admin\SettingController::class, 'clearCache'])->name('clear-cache');
    });

/*
|--------------------------------------------------------------------------
| Auth routes (Breeze) + Profile
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
