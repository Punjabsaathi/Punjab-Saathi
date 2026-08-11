<?php

namespace App\Services\AI;

class LanguageDetectorService
{
    /**
     * Detect language from text using Unicode range heuristics.
     * Falls back to 'en' for ambiguous inputs.
     *
     * Supported: 'en' (English), 'hi' (Hindi/Devanagari), 'pa' (Punjabi/Gurmukhi)
     */
    public function detect(string $text): string
    {
        $text = trim($text);

        if (empty($text)) return 'en';

        // Gurmukhi Unicode range: U+0A00–U+0A7F
        if (preg_match('/[\x{0A00}-\x{0A7F}]/u', $text)) {
            return 'pa';
        }

        // Devanagari Unicode range: U+0900–U+097F (Hindi)
        if (preg_match('/[\x{0900}-\x{097F}]/u', $text)) {
            return 'hi';
        }

        // Default to English for Latin script
        return 'en';
    }

    /**
     * Detect language and return confidence (for logging)
     */
    public function detectWithConfidence(string $text): array
    {
        $lang = $this->detect($text);
        $totalChars = mb_strlen($text);

        if ($totalChars === 0) {
            return ['language' => 'en', 'confidence' => 0.0];
        }

        // Count script-specific characters
        $counts = [
            'pa' => preg_match_all('/[\x{0A00}-\x{0A7F}]/u', $text),
            'hi' => preg_match_all('/[\x{0900}-\x{097F}]/u', $text),
            'en' => preg_match_all('/[a-zA-Z]/', $text),
        ];

        $dominant = array_key_first(array_diff_key($counts, array_filter($counts, fn($v) => $v === 0)));
        $confidence = round(($counts[$lang] ?? 0) / $totalChars, 2);

        return ['language' => $lang, 'confidence' => min($confidence, 1.0)];
    }
}