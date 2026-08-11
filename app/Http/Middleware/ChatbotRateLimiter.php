<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class ChatbotRateLimiter
{
    /**
     * Allow 30 messages per minute per IP (guests) or per user ID (authenticated).
     * Authenticated users get a higher limit (60/min).
     */
    public function handle(Request $request, Closure $next): Response
    {
        $identifier = $request->user()
            ? 'user:' . $request->user()->id
            : 'ip:' . $request->ip();

        $limit = $request->user() ? 60 : 30;

        $executed = RateLimiter::attempt(
            key:          'chatbot:' . $identifier,
            maxAttempts:  $limit,
            callback:     fn() => true,
            decaySeconds: 60,
        );

        if (!$executed) {
            $retryAfter = RateLimiter::availableIn('chatbot:' . $identifier);

            return response()->json([
                'error'       => 'Too many requests. Please wait before sending another message.',
                'retry_after' => $retryAfter,
            ], 429)->withHeaders([
                'X-RateLimit-Limit'     => $limit,
                'X-RateLimit-Remaining' => 0,
                'Retry-After'           => $retryAfter,
            ]);
        }

        $response = $next($request);

        return $response->withHeaders([
            'X-RateLimit-Limit'     => $limit,
            'X-RateLimit-Remaining' => RateLimiter::remaining('chatbot:' . $identifier, $limit),
        ]);
    }
}