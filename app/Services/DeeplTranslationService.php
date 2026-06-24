<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class DeeplTranslationService
{
    public function translate(string $text, string $targetLocale): string
    {
        if (trim($text) === '') {
            return '';
        }

        if (!config('services.deepl.key')) {
            return $text;
        }

        $targetLang = match ($targetLocale) {
            'lv' => 'LV',
            'en' => 'EN-GB',
            default => 'LV',
        };

        $response = Http::withHeaders([
            'Authorization' => 'DeepL-Auth-Key ' . config('services.deepl.key'),
            'Content-Type' => 'application/json',
        ])->post(config('services.deepl.url'), [
            'text' => [$text],
            'target_lang' => $targetLang,
        ]);

        if (!$response->successful()) {
            return $text;
        }

        return $response->json('translations.0.text') ?? $text;
    }
}
