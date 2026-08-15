<?php

namespace App\Services\AI;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class GeminiService
{
    // Groq config — primary generator for generate/translate/classify
    protected string $groqApiKey;
    protected string $groqModel;
    protected string $groqBaseUrl = 'https://api.groq.com/openai/v1';

    // Gemini config — embeddings, and fallback generation when Groq fails
    protected string $geminiApiKey;
    protected string $embedModel;
    protected string $geminiChatModel;
    protected string $geminiBaseUrl = 'https://generativelanguage.googleapis.com/v1beta';

    public function __construct()
    {
        // Groq
        $this->groqApiKey = config('chatbot.groq_api_key');
        $this->groqModel  = config('chatbot.groq_model', 'llama-3.1-8b-instant');

        // Gemini (embeddings + fallback generation)
        $this->geminiApiKey    = config('chatbot.gemini_api_key');
        $this->embedModel      = config('chatbot.gemini_embed_model', 'gemini-embedding-001');
        $this->geminiChatModel = config('chatbot.gemini_model', 'gemini-2.0-flash');
    }

    /**
     * Generate a response — Groq primary, Gemini fallback on any failure
     * (rate limit, timeout, API error). Gemini is only ever called when
     * the Groq attempt throws, so a healthy request costs exactly one
     * API call, same as before this fallback was added.
     */
    public function generate(string $prompt, array $options = []): array
    {
        try {
            $result = $this->generateViaGroq($prompt, $options);
            $result['provider'] = 'groq';
            return $result;
        } catch (\Throwable $e) {
            Log::warning('Groq generation failed, falling back to Gemini', [
                'error' => $e->getMessage(),
            ]);

            try {
                $result = $this->generateViaGemini($prompt, $options);
                $result['provider'] = 'gemini';
                return $result;
            } catch (\Throwable $e2) {
                Log::error('Both Groq and Gemini generation failed', [
                    'groq_error'   => $e->getMessage(),
                    'gemini_error' => $e2->getMessage(),
                ]);

                throw new \RuntimeException('AI generation unavailable');
            }
        }
    }

    protected function generateViaGroq(string $prompt, array $options = []): array
    {
        $response = Http::timeout(30)
            ->withHeaders([
                'Authorization' => 'Bearer ' . $this->groqApiKey,
                'Content-Type'  => 'application/json',
            ])
            ->retry(2, 500, function ($exception) {
                if ($exception instanceof \Illuminate\Http\Client\RequestException) {
                    return $exception->response->status() !== 429;
                }
                return true;
            })
            ->post("{$this->groqBaseUrl}/chat/completions", [
                'model'       => $this->groqModel,
                'temperature' => $options['temperature'] ?? 0.3,
                'max_tokens'  => $options['max_tokens'] ?? 1024,
                'messages'    => [
                    ['role' => 'user', 'content' => $prompt]
                ],
            ]);

        if ($response->failed()) {
            $status   = $response->status();
            $errorMsg = $response->json()['error']['message'] ?? 'Unknown error';

            Log::error('Groq API error', [
                'status' => $status,
                'body'   => $response->body(),
            ]);

            throw new \RuntimeException("Groq API failed: {$status} - {$errorMsg}");
        }

        $data = $response->json();
        $text = $data['choices'][0]['message']['content'] ?? '';

        return [
            'text'   => trim($text),
            'tokens' => $data['usage']['total_tokens'] ?? 0,
        ];
    }

    protected function generateViaGemini(string $prompt, array $options = []): array
    {
        $url = "{$this->geminiBaseUrl}/models/{$this->geminiChatModel}:generateContent?key={$this->geminiApiKey}";

        $response = Http::timeout(20)
            ->retry(1, 300, function ($exception) {
                if ($exception instanceof \Illuminate\Http\Client\RequestException) {
                    return $exception->response->status() !== 429;
                }
                return true;
            })
            ->post($url, [
                'contents' => [
                    ['role' => 'user', 'parts' => [['text' => $prompt]]],
                ],
                'generationConfig' => [
                    'temperature'     => $options['temperature'] ?? 0.3,
                    'maxOutputTokens' => $options['max_tokens'] ?? 1024,
                ],
            ]);

        if ($response->failed()) {
            $status   = $response->status();
            $errorMsg = $response->json()['error']['message'] ?? 'Unknown error';

            Log::error('Gemini generate error', [
                'status' => $status,
                'body'   => $response->body(),
            ]);

            throw new \RuntimeException("Gemini generate failed: {$status} - {$errorMsg}");
        }

        $data = $response->json();
        $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? '';

        return [
            'text'   => trim($text),
            'tokens' => $data['usageMetadata']['totalTokenCount'] ?? 0,
        ];
    }

    /**
     * Generate embedding — keeps Gemini (no alternative needed)
     * Cached 7 days — embeddings are deterministic
     */
    public function embed(string $text): array
    {
        $cacheKey = 'embed:' . md5($text);

        return Cache::remember($cacheKey, 604800, function () use ($text) {
            $url = "{$this->geminiBaseUrl}/models/{$this->embedModel}:embedContent?key={$this->geminiApiKey}";

            $response = Http::timeout(15)
                ->retry(2, 300, function ($exception) {
                    if ($exception instanceof \Illuminate\Http\Client\RequestException) {
                        return $exception->response->status() !== 429;
                    }
                    return true;
                })
                ->post($url, [
                    'content' => [
                        'parts' => [['text' => $text]]
                    ]
                ]);

            if ($response->failed()) {
                $status   = $response->status();
                $errorMsg = $response->json()['error']['message'] ?? 'Embedding failed';

                Log::error('Gemini embed error', [
                    'status' => $status,
                    'body'   => $response->body(),
                ]);

                if ($status === 429) {
                    throw new \RuntimeException('Gemini embedding quota exceeded.');
                }

                throw new \RuntimeException("Gemini embed failed: {$status} - {$errorMsg}");
            }

            return $response->json('embedding.values', []);
        });
    }

    /**
     * Translate text — Groq primary, Gemini fallback (inherited from generate())
     * Cached 24 hours
     */
    public function translate(string $text, string $targetLang): string
    {
        if ($targetLang === 'en') return $text;

        $langNames = ['hi' => 'Hindi', 'pa' => 'Punjabi (Gurmukhi)', 'en' => 'English'];
        $langName  = $langNames[$targetLang] ?? 'English';

        $cacheKey = 'translate:' . md5($text . $targetLang);

        return Cache::remember($cacheKey, 86400, function () use ($text, $langName, $targetLang) {
            $prompt = "Translate the following text to {$langName}. Output only the translation, nothing else:\n\n{$text}";

            try {
                $result = $this->generate($prompt, ['temperature' => 0.1, 'max_tokens' => 512]);
                return $result['text'];
            } catch (\Exception $e) {
                Log::warning('Translation failed, returning original', [
                    'lang'  => $targetLang,
                    'error' => $e->getMessage(),
                ]);
                return $text;
            }
        });
    }

    /**
     * Classify intent — Groq primary, Gemini fallback (inherited from generate())
     */
    public function classify(string $text, array $categories): string
    {
        $categoryList = implode(', ', $categories);
        $prompt = "Classify the following text into exactly one of these categories: {$categoryList}.\n"
            . "Output only the category name, nothing else.\n\nText: {$text}";

        try {
            $result   = $this->generate($prompt, ['temperature' => 0.0, 'max_tokens' => 32]);
            $category = trim(strtolower($result['text']));
            return in_array($category, $categories) ? $category : $categories[0];
        } catch (\Exception $e) {
            Log::warning('Classification failed', ['error' => $e->getMessage()]);
            return $categories[0];
        }
    }

    /**
     * Health check — quick single-call check (transparently succeeds via
     * Gemini if Groq is down, since generate() already falls back).
     */
    public function healthCheck(): bool
    {
        try {
            $result = $this->generate('Say "ok" only.', ['max_tokens' => 8]);
            return !empty($result['text']);
        } catch (\Exception $e) {
            Log::warning('Health check failed', ['error' => $e->getMessage()]);
            return false;
        }
    }

    /**
     * Diagnostic check of each provider independently — unlike
     * healthCheck(), this does NOT fall back, so it can distinguish
     * "Groq is down but Gemini covers it" from "everything is down".
     * Useful for future admin/ops tooling.
     */
    public function healthCheckDetailed(): array
    {
        $groqOk = false;
        $geminiOk = false;

        try {
            $this->generateViaGroq('Say "ok" only.', ['max_tokens' => 8]);
            $groqOk = true;
        } catch (\Throwable $e) {
            Log::warning('Groq health check failed', ['error' => $e->getMessage()]);
        }

        try {
            $this->generateViaGemini('Say "ok" only.', ['max_tokens' => 8]);
            $geminiOk = true;
        } catch (\Throwable $e) {
            Log::warning('Gemini health check failed', ['error' => $e->getMessage()]);
        }

        return ['groq' => $groqOk, 'gemini' => $geminiOk];
    }
}
