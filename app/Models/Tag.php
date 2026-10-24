<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['slug', 'name_bn', 'name_en'];

    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }

    public function getName(): string
    {
        $locale = App::getLocale();

        return ($locale === 'en' && $this->name_en) ? $this->name_en : $this->name_bn;
    }
}
