<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class JobAlert extends Model
{
    protected $fillable = [
        'email',
        'keyword',
        'location',
        'employment_type',
        'unsubscribe_token',
        'is_active',
        'last_sent_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'last_sent_at' => 'datetime',
    ];

    public static function subscribeEmail(string $email, array $params = []): static
    {
        return static::firstOrCreate(
            ['email' => $email],
            array_merge($params, [
                'unsubscribe_token' => Str::random(64),
                'is_active' => true,
            ])
        );
    }
}
