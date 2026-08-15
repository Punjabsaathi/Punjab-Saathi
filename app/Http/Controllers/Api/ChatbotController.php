<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ChatSession;
use App\Models\ChatMessage;
use App\Services\AI\GeminiService;
use App\Services\RAG\RagPipelineService;
use App\Services\AI\LanguageDetectorService;
use App\Jobs\LogChatAnalyticsJob;
use App\jobs\SyncEmbeddingJob;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    public function __construct(
        protected GeminiService $gemini,
        protected RagPipelineService $rag,
        protected LanguageDetectorService $langDetector,
    ) {}

    /**
     * Start or resume a chat session
     */
    public function startSession(Request $request): JsonResponse
    {
        $token = $request->header('X-Chat-Token') ?? Str::uuid()->toString();

        $session = ChatSession::firstOrCreate(
            ['session_token' => $token],
            [
                'id'         => Str::uuid(),
                'user_id'    => auth()->id(),
                'language'   => 'en',
                'expires_at' => now()->addHours(config('chatbot.session_ttl', 2)),
            ]
        );

        return response()->json([
            'session_token' => $session->session_token,
            'language'      => $session->language,
            'greeting'      => $this->getGreeting($session->language),
        ]);
    }

    /**
     * Main chat endpoint
     */
    public function sendMessage(Request $request): JsonResponse
    {
        $request->validate([
            'message'       => 'required|string|max:1000',
            'session_token' => 'required|string|uuid',
            'language'      => 'nullable|string|in:en,hi,pa',
        ]);

        $session = ChatSession::where('session_token', $request->session_token)
            ->where('expires_at', '>', now())
            ->firstOrFail();

        $session->update([
            'expires_at' => now()->addHours(config('chatbot.session_ttl', 2))
        ]);

        $userMessage = trim($request->message);

        // A language the user has explicitly picked in the UI is
        // authoritative and must not be silently overridden by per-message
        // script detection — that detection only decides language for
        // turns where the client hasn't told us a pinned choice yet
        // (first message, or an older client that doesn't send it).
        if ($request->filled('language')) {
            $detectedLang = $request->language;
            if ($detectedLang !== $session->language) {
                $session->update(['language' => $detectedLang]);
            }
        } else {
            $detectedLang = $this->langDetector->detect($userMessage);
            if ($detectedLang !== $session->language) {
                $session->update(['language' => $detectedLang]);
            }
        }

        $userMsg = ChatMessage::create([
            'session_id' => $session->id,
            'role'       => 'user',
            'content'    => $userMessage,
            'language'   => $detectedLang,
        ]);

        $startTime = microtime(true);

        try {
            $response = $this->rag->process(
                query:    $userMessage,
                session:  $session,
                language: $detectedLang,
            );
        } catch (\Throwable $e) {
            Log::error('Chatbot pipeline error', [
                'error'   => $e->getMessage(),
                'session' => $session->id,
            ]);
            $response = $this->fallbackResponse($detectedLang);
        }

        $latency = (int) ((microtime(true) - $startTime) * 1000);

        $assistantMsg = ChatMessage::create([
            'session_id'  => $session->id,
            'role'        => 'assistant',
            'content'     => $response['answer'],
            'language'    => $detectedLang,
            'intent'      => $response['intent'] ?? 'general',
            'tokens_used' => $response['tokens'] ?? 0,
            'latency_ms'  => $latency,
        ]);

        LogChatAnalyticsJob::dispatch(
            sessionId:          $session->id,
            userMessageId:      $userMsg->id,
            assistantMessageId: $assistantMsg->id,
            latencyMs:          $latency,
            intent:             $response['intent'] ?? null,
            language:           $detectedLang,
            chunksRetrieved:    $response['chunks_count'] ?? 0,
            topSimilarity:      $response['top_similarity'] ?? null,
            provider:           $response['provider'] ?? null,
        );

        return response()->json([
            'id'            => $assistantMsg->id,
            'answer'        => $response['answer'],
            'intent'        => $response['intent'] ?? 'general',
            'sources'       => $response['sources'] ?? [],
            'language'      => $detectedLang,
            'quick_replies' => $response['quick_replies'] ?? [],
            'latency_ms'    => $latency,
        ]);
    }

    /**
     * Get conversation history
     */
    public function getHistory(Request $request): JsonResponse
    {
        $session = ChatSession::where('session_token', $request->session_token)->firstOrFail();

        $messages = ChatMessage::where('session_id', $session->id)
            ->orderBy('created_at')
            ->limit(50)
            ->get(['role', 'content', 'language', 'intent', 'created_at']);

        return response()->json(['messages' => $messages]);
    }

    /**
     * Admin: sync embeddings
     */
    public function syncEmbeddings(Request $request): JsonResponse
    {
        $types = $request->input('types', ['service', 'faq', 'document', 'form', 'job', 'blog']);

        foreach ($types as $type) {
            SyncEmbeddingJob::dispatch($type);
        }

        return response()->json(['message' => 'Embedding sync jobs dispatched.', 'types' => $types]);
    }

    protected function getGreeting(string $lang): string
    {
        return match($lang) {
            'hi'    => 'नमस्ते! मैं Punjab Saathi का AI सहायक हूं। मैं आपकी कैसे मदद कर सकता हूं?',
            'pa'    => 'ਸਤ ਸ੍ਰੀ ਅਕਾਲ! ਮੈਂ Punjab Saathi ਦਾ AI ਸਹਾਇਕ ਹਾਂ। ਮੈਂ ਤੁਹਾਡੀ ਕਿਵੇਂ ਮਦਦ ਕਰ ਸਕਦਾ ਹਾਂ?',
            default => 'Hello! I\'m the Punjab Saathi AI Assistant. How can I help you today?',
        };
    }

    protected function fallbackResponse(string $lang): array
    {
        $msg = match($lang) {
            'hi'    => 'मुझे खेद है, अभी तकनीकी समस्या है। कृपया पुनः प्रयास करें।',
            'pa'    => 'ਮੈਨੂੰ ਅਫਸੋਸ ਹੈ, ਹੁਣ ਤਕਨੀਕੀ ਸਮੱਸਿਆ ਹੈ। ਕਿਰਪਾ ਦੁਬਾਰਾ ਕੋਸ਼ਿਸ਼ ਕਰੋ।',
            default => 'I\'m sorry, there is a technical issue right now. Please try again.',
        };

        return ['answer' => $msg, 'intent' => 'error', 'sources' => [], 'quick_replies' => []];
    }
}
