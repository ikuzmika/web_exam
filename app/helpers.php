<?php

use App\Services\DeepLTranslationService;
use Illuminate\Support\Facades\Cache;

if (!function_exists('translate_db')) {
    function translate_db(?string $text, ?string $targetLocale = null): string
    {
        if (!$text) {
            return '';
        }

        $targetLocale = $targetLocale ?? app()->getLocale();
        $originalLocale = config('app.db_text_locale', 'en');

        if ($targetLocale === $originalLocale) {
            return $text;
        }

        if (!in_array($targetLocale, ['en', 'lv'])) {
            return $text;
        }

        $cacheKey = 'db_translation_' . md5($targetLocale . '_' . $text);

        return Cache::remember($cacheKey, now()->addDays(30), function () use ($text, $targetLocale) {
            return app(DeepLTranslationService::class)->translate($text, $targetLocale);
        });
    }
}
