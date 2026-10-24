<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OneSignalService
{
    /**
     * Send a web push notification to all subscribed users.
     */
    public static function sendPush(string $title, string $message, string $url, ?string $imageUrl = null): bool
    {
        $appId = config('services.onesignal.app_id');
        $apiKey = config('services.onesignal.rest_api_key');

        if (empty($appId) || empty($apiKey)) {
            Log::warning('OneSignal push notification skipped: Missing APP_ID or REST_API_KEY.');

            return false;
        }

        $payload = [
            'app_id' => $appId,
            'included_segments' => ['Total Subscriptions'],
            'headings' => [
                'en' => $title,
            ],
            'contents' => [
                'en' => $message,
            ],
            'url' => $url,
            'chrome_web_icon' => asset('images/logo-icon.png'),
        ];

        if (! empty($imageUrl)) {
            $payload['big_picture'] = $imageUrl;
            $payload['chrome_web_image'] = $imageUrl;
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Key '.$apiKey,
                'Content-Type' => 'application/json; charset=utf-8',
            ])->timeout(10)->post('https://api.onesignal.com/notifications', $payload);

            if ($response->successful()) {
                Log::info('OneSignal push sent successfully: '.$title, $response->json());

                return true;
            }

            Log::error('OneSignal push failed: '.$response->status(), $response->json());

            return false;
        } catch (\Throwable $e) {
            Log::error('OneSignal push exception: '.$e->getMessage());

            return false;
        }
    }
}
