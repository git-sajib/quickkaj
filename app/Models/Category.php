<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\App;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'name_bn',
        'name_en',
        'description_bn',
        'description_en',
        'icon',
        'parent_id',
        'order',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    public function getName(): string
    {
        $locale = App::getLocale();

        return ($locale === 'en' && $this->name_en) ? $this->name_en : $this->name_bn;
    }
}
