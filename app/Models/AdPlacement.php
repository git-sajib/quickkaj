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

    public static function getSmartlinkUrl(): string
    {
        $slot = static::getSlot('smartlink');
        if ($slot && ! empty($slot->html_code)) {
            $url = trim($slot->html_code);
            if (filter_var($url, FILTER_VALIDATE_URL)) {
                return $url;
            }
            if (preg_match('/href=[\'"]([^\'"]+)[\'"]/', $url, $m)) {
                return $m[1];
            }

            return $url;
        }

        return 'https://asiafilm.org/4/33e4688bf6afae608fef6c06eb86d1c9';
    }
}
