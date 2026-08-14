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
use Illuminate\Support\Facades\Cache;
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
                // ✅ FIX: was config('chatbot.session_ttl') nested wrong
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
            'session_token' => 'required|string',
        ]);

        $session = ChatSession::where('session_token', $request->session_token)
            ->where('expires_at', '>', now())
            ->firstOrFail();

        // ✅ FIX: touch() ignores extra arguments — use update() instead
        $session->update([
            'expires_at' => now()->addHours(config('chatbot.session_ttl', 2))
        ]);

        $userMessage  = trim($request->message);
        $detectedLang = $this->langDetector->detect($userMessage);

        if ($detectedLang !== $session->language) {
            $session->update(['language' => $detectedLang]);
        }

        $userMsg = ChatMessage::create([
            'session_id' => $session->id,
            'role'       => 'user',
            'content'    => $userMessage,
            'language'   => $detectedLang,
        ]);

        $refNumber = $this->extractReferenceNumber($userMessage);
        $startTime = microtime(true);

        try {
            if ($refNumber) {
                $response = $this->handleStatusCheck($refNumber, $detectedLang, $session);
            } else {
                $response = $this->rag->process(
                    query:    $userMessage,
                    session:  $session,
                    language: $detectedLang,
                );
            }
        } catch (\Exception $e) {
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

        LogChatAnalyticsJob::dispatch($session->id, $userMsg->id, $assistantMsg->id, $latency);

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
     * Application status check
     */
    protected function handleStatusCheck(string $refNumber, string $lang, ChatSession $session): array
    {
        $cacheKey = "app_status:{$refNumber}";

        $application = Cache::remember($cacheKey, 60, function () use ($refNumber) {
            return \App\Models\Application::with(['service', 'statusLogs'])
                ->where('reference_number', $refNumber)
                ->first();
        });

        if (!$application) {
            return [
                'answer'        => $this->translate("No application found with reference number **{$refNumber}**. Please double-check the number.", $lang),
                'intent'        => 'status_check',
                'sources'       => [],
                'quick_replies' => ['Try another number', 'Contact support'],
            ];
        }

        $statusMessages = [
            'pending'            => 'Your application is pending review.',
            'under_review'       => 'Your application is currently under review by our team.',
            'approved'           => 'Congratulations! Your application has been approved.',
            'rejected'           => 'Your application was not approved. Please contact the office for details.',
            'documents_required' => 'Additional documents are required. Please visit the nearest Seva Kendra.',
        ];

        $statusText = $statusMessages[$application->status] ?? 'Status: ' . $application->status;

        $answer = "**Application Status for #{$refNumber}**\n\n"
            . "Service: {$application->service->name}\n"
            . "Applicant: {$application->applicant_name}\n"
            . "Submitted: {$application->created_at->format('d M Y')}\n"
            . "Status: **" . strtoupper($application->status) . "**\n\n"
            . $statusText;

        return [
            'answer'        => $this->translate($answer, $lang),
            'intent'        => 'status_check',
            'sources'       => [],
            'quick_replies' => ['What documents do I need?', 'Visit nearest center', 'Contact helpline'],
        ];
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
        $types = $request->input('types', ['service', 'faq', 'document', 'blog']);

        foreach ($types as $type) {
            SyncEmbeddingJob::dispatch($type);
        }

        return response()->json(['message' => 'Embedding sync jobs dispatched.', 'types' => $types]);
    }

    protected function extractReferenceNumber(string $message): ?string
    {
        if (preg_match('/\b(?:PSK|REF|APP)?[-\s]?(\d{6,12})\b/i', $message, $matches)) {
            return strtoupper(trim($matches[0]));
        }
        return null;
    }

    protected function getGreeting(string $lang): string
    {
        return match($lang) {
            'hi'    => 'नमस्ते! मैं Punjab Seva Kendra का AI सहायक हूं। मैं आपकी कैसे मदद कर सकता हूं?',
            'pa'    => 'ਸਤ ਸ੍ਰੀ ਅਕਾਲ! ਮੈਂ Punjab Seva Kendra ਦਾ AI ਸਹਾਇਕ ਹਾਂ। ਮੈਂ ਤੁਹਾਡੀ ਕਿਵੇਂ ਮਦਦ ਕਰ ਸਕਦਾ ਹਾਂ?',
            default => 'Hello! I\'m the Punjab Seva Kendra AI Assistant. How can I help you today?',
        };
    }

    protected function translate(string $text, string $lang): string
    {
        if ($lang === 'en') return $text;
        return $this->gemini->translate($text, $lang);
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