<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\App;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title_bn',
        'title_en',
        'excerpt_bn',
        'excerpt_en',
        'body_bn',
        'body_en',
        'featured_image',
        'category_id',
        'author_id',
        'is_published',
        'is_featured',
        'published_at',
        'seo_title',
        'seo_description',
        'og_image',
        'views',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function scopePublished($query): mixed
    {
        return $query->where('is_published', true)->whereNotNull('published_at');
    }

    public function scopeFeatured($query): mixed
    {
        return $query->where('is_featured', true);
    }

    public function getTitle(): string
    {
        $locale = App::getLocale();

        return ($locale === 'en' && $this->title_en) ? $this->title_en : $this->title_bn;
    }

    public function getExcerpt(): string
    {
        $locale = App::getLocale();

        return ($locale === 'en' && $this->excerpt_en) ? $this->excerpt_en : ($this->excerpt_bn ?? '');
    }

    public function getBody(): string
    {
        $locale = App::getLocale();

        return ($locale === 'en' && $this->body_en) ? $this->body_en : ($this->body_bn ?? '');
    }

    /**
     * Returns article body HTML with ad HTML injected after every Nth paragraph.
     * Pass $adHtml = null to skip injection (when no active ad slot).
     *
     * @param  string|null  $adHtml  Raw ad HTML to inject (from AdPlacement model)
     * @param  int  $every  Inject ad after every N paragraphs (default: 3)
     */
    public function getBodyWithAds(?string $adHtml = null, int $every = 3): string
    {
        $body = $this->getBody();

        if (empty($adHtml) || empty($body)) {
            return $body;
        }

        // Split on closing </p> or </h2>/<h3> tags keeping the delimiter
        $parts = preg_split('/(<\/p>|<\/h[23]>)/i', $body, -1, PREG_SPLIT_DELIM_CAPTURE);

        $output = '';
        $paraCount = 0;
        $adBlock = '<div class="my-5 p-3 bg-gray-50 rounded-xl text-center border border-gray-100 ad-inline-block">'
            .'<p class="text-[10px] text-gray-300 mb-1 uppercase tracking-widest">Advertisement</p>'
            .$adHtml
            .'</div>';

        foreach ($parts as $part) {
            $output .= $part;

            // Each closing tag increments our paragraph counter
            if (preg_match('/^<\/p>$|^<\/h[23]>$/i', trim($part))) {
                $paraCount++;
                if ($paraCount % $every === 0) {
                    $output .= $adBlock;
                }
            }
        }

        return $output;
    }
}
