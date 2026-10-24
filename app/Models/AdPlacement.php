<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdPlacement extends Model
{
    use HasFactory;

    protected $fillable = ['slot_key', 'label', 'html_code', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public static function getSlot(string $slotKey): ?self
    {
        return static::where('slot_key', $slotKey)->where('is_active', true)->first();
    }
}
