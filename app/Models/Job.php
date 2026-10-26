<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\App;

class Job extends Model
{
    use HasFactory;

    protected $table = 'job_listings';

    protected $fillable = [
        'slug',
        'title_bn',
        'title_en',
        'employer_bn',
        'employer_en',
        'location_bn',
        'location_en',
        'eligibility_bn',
        'eligibility_en',
        'description_bn',
        'description_en',
        'deadline',
        'source_url',
        'application_url',
        'employment_type',
        'education_level',
        'category_id',
        'featured_image',
        'circular_pdf',
        'is_published',
        'is_verified',
        'is_outdated',
        'published_at',
        'seo_title',
        'seo_description',
        'views',
        'created_by',
    ];

    protected $casts = [
        'deadline' => 'date',
        'published_at' => 'datetime',
        'is_published' => 'boolean',
        'is_verified' => 'boolean',
        'is_outdated' => 'boolean',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function savedByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'saved_jobs', 'job_id', 'user_id')
            ->withPivot('saved_at');
    }

    public function scopePublished($query): mixed
    {
        return $query->where('is_published', true);
    }

    public function scopeActive($query): mixed
    {
        return $query->published()->where('is_outdated', false)->where(function ($q) {
            $q->whereNull('deadline')->orWhere('deadline', '>=', now()->toDateString());
        });
    }

    /**
     * Apply search filters from request query params.
     * Supports: q (keyword), location, employment_type, education_level,
     *           category, deadline_within (days), expired (boolean).
     */
    public function scopeSearch($query, array $filters): mixed
    {
        if (! empty($filters['q'])) {
            $term = '%'.$filters['q'].'%';
            $query->where(function ($q) use ($term) {
                $q->where('title_bn', 'like', $term)
                    ->orWhere('title_en', 'like', $term)
                    ->orWhere('employer_bn', 'like', $term)
                    ->orWhere('employer_en', 'like', $term);
            });
        }

        if (! empty($filters['location'])) {
            $loc = '%'.$filters['location'].'%';
            $query->where(function ($q) use ($loc) {
                $q->where('location_bn', 'like', $loc)
                    ->orWhere('location_en', 'like', $loc);
            });
        }

        if (! empty($filters['employment_type'])) {
            $query->where('employment_type', $filters['employment_type']);
        }

        if (! empty($filters['education_level'])) {
            $query->where('education_level', $filters['education_level']);
        }

        if (! empty($filters['category'])) {
            $query->where('category_id', $filters['category']);
        }

        if (! empty($filters['deadline_within'])) {
            $query->where('deadline', '<=', now()->addDays((int) $filters['deadline_within'])->toDateString())
                ->whereNotNull('deadline');
        }

        if (isset($filters['expired']) && $filters['expired'] === '1') {
            $query->where('deadline', '<', now()->toDateString());
        } else {
            // Default: hide expired
            $query->where(function ($q) {
                $q->whereNull('deadline')->orWhere('deadline', '>=', now()->toDateString());
            });
        }

        return $query;
    }

    public function getTitle(): string
    {
        $locale = App::getLocale();

        return ($locale === 'en' && $this->title_en) ? $this->title_en : $this->title_bn;
    }

    public function getEmployer(): string
    {
        $locale = App::getLocale();

        return ($locale === 'en' && $this->employer_en) ? $this->employer_en : ($this->employer_bn ?? '');
    }

    public function getLocation(): string
    {
        $locale = App::getLocale();

        return ($locale === 'en' && $this->location_en) ? $this->location_en : ($this->location_bn ?? '');
    }

    public function getDescription(): string
    {
        $locale = App::getLocale();

        return ($locale === 'en' && $this->description_en) ? $this->description_en : ($this->description_bn ?? '');
    }

    public function isExpired(): bool
    {
        return $this->deadline && $this->deadline->isPast();
    }

    public function hasCircularPdf(): bool
    {
        return ! empty($this->circular_pdf);
    }

    public function getCircularPdfUrl(): ?string
    {
        return $this->circular_pdf ? asset('storage/'.$this->circular_pdf) : null;
    }

    public function hasFeaturedImage(): bool
    {
        return ! empty($this->featured_image);
    }

    public function getFeaturedImageUrl(): ?string
    {
        return $this->featured_image ? asset('storage/'.$this->featured_image) : null;
    }
}
