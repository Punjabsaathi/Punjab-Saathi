<?php

namespace App\Services\RAG;

use App\Models\ChatMessage;
use App\Models\ChatSession;
use App\Services\AI\GeminiService;
use App\Services\Embedding\EmbeddingService;
use App\Services\RAG\VectorSearchService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RagPipelineService
{
    public function __construct(
        protected GeminiService $gemini,
        protected EmbeddingService $embeddingService,
        protected VectorSearchService $vectorSearch,
    ) {}

    /**
     * Full RAG pipeline
     */
    public function process(string $query, ChatSession $session, string $language): array
    {
        // Step 1: Detect intent
        $intent = $this->classifyIntent($query);

        // Step 2: Check if status_check intent — handle directly from DB, no AI needed
        if ($intent === 'status_check') {
            $statusResponse = $this->handleStatusCheck($query, $session, $language);
            if ($statusResponse !== null) {
                return $statusResponse;
            }
        }

        // Step 3: Translate to English for embedding only if not English
        $searchQuery = ($language !== 'en')
            ? $this->gemini->translate($query, 'en')
            : $query;

        // Step 4: Cache key
        $cacheKey = 'rag:' . md5($query . ':' . $language);

        if ($cached = Cache::get($cacheKey)) {
            return $cached;
        }

        // Step 5: Embed the search query
        $queryVector = $this->embeddingService->embedText($searchQuery);

        // Step 6: Vector search
        $topK   = config('chatbot.rag_top_k', 6);
        $chunks = $this->vectorSearch->search(
            $queryVector,
            $topK,
            $this->getSourceTypesForIntent($intent),
        );

        // Step 7: Conversation history
        $history = $this->getConversationHistory($session);

        // Step 8: Build prompt
        $prompt = $this->buildPrompt(
            query:    $query,
            chunks:   $chunks,
            history:  $history,
            language: $language,
            intent:   $intent,
        );

        // Step 9: Generate response
        $geminiResponse = $this->gemini->generate($prompt);

        // Step 10: Build response
        $sources      = $this->buildSources($chunks);
        $quickReplies = $this->generateQuickReplies($intent, $language);

        $result = [
            'answer'        => $geminiResponse['text'],
            'intent'        => $intent,
            'sources'       => $sources,
            'quick_replies' => $quickReplies,
            'tokens'        => $geminiResponse['tokens'] ?? 0,
        ];

        Cache::put($cacheKey, $result, 3600);

        return $result;
    }

    /**
     * Handle application status check — pure MySQL, zero AI calls
     */
    protected function handleStatusCheck(string $query, ChatSession $session, string $language): ?array
    {
        // Extract reference number from query e.g. PSK-2026-D810A8
        preg_match('/PSK-\d{4}-[A-Z0-9]+/i', $query, $matches);
        $referenceNo = $matches[0] ?? null;

        // No reference number found — ask user to provide it
        if (!$referenceNo) {
            // Check session for previously asked reference number request
            $lastMessage = ChatMessage::where('session_id', $session->id)
                ->where('role', 'assistant')
                ->latest()
                ->value('content');

            $isAskedAlready = $lastMessage && str_contains($lastMessage, 'reference number');

            $answer = $isAskedAlready
                ? "I still couldn't find a reference number in your message. Please type it in this format: PSK-2026-XXXXXX"
                : "Sure! Please provide your application reference number to check the status. It looks like this: PSK-2026-XXXXXX";

            return [
                'answer'        => $answer,
                'intent'        => 'status_check',
                'sources'       => [],
                'quick_replies' => ['PSK-2026-D810A8 (example)', 'Contact helpline', 'Visit nearest center'],
                'tokens'        => 0,
            ];
        }

        // Look up application in DB
        $application = DB::table('service_applications')
            ->where('reference_no', strtoupper($referenceNo))
            ->first();

        // Not found
        if (!$application) {
            return [
                'answer'        => "❌ No application found with reference number **{$referenceNo}**.\n\nPlease check the number and try again. If you need help, call our helpline: " . config('chatbot.helpline', '1800-180-XXXX'),
                'intent'        => 'status_check',
                'sources'       => [],
                'quick_replies' => ['Try again', 'Contact helpline', 'Visit nearest center'],
                'tokens'        => 0,
            ];
        }

        // Get service name
        $serviceName = DB::table('services')
            ->where('id', $application->service_id)
            ->value('title') ?? 'Government Service';

        // Format status nicely
        $statusLabel = match($application->status) {
            'pending'     => '🟡 Pending — Your application is received and awaiting review.',
            'in_progress' => '🔵 In Progress — Your application is currently being processed.',
            'approved'    => '✅ Approved — Your application has been approved.',
            'rejected'    => '❌ Rejected — Your application was not approved.',
            'completed'   => '✅ Completed — Your service has been delivered.',
            'on_hold'     => '⏸️ On Hold — Additional information is required.',
            default       => ucfirst($application->status),
        };

        // Format date
        $submittedDate = $application->created_at
            ? date('d M Y', strtotime($application->created_at))
            : 'N/A';

        $updatedDate = $application->updated_at
            ? date('d M Y', strtotime($application->updated_at))
            : 'N/A';

        // Build answer
        $answer = implode("\n", array_filter([
            "📋 **Application Status**",
            "",
            "**Reference No:** {$referenceNo}",
            "**Applicant:** {$application->name}",
            "**Service:** {$serviceName}",
            "**Status:** {$statusLabel}",
            "**Submitted:** {$submittedDate}",
            "**Last Updated:** {$updatedDate}",
            $application->admin_notes
                ? "\n📝 **Note from our team:** {$application->admin_notes}"
                : null,
            "",
            "For further assistance, call: " . config('chatbot.helpline', '1800-180-XXXX'),
        ]));

        // Translate if needed
        if ($language !== 'en') {
            $answer = $this->gemini->translate($answer, $language);
        }

        return [
            'answer'        => $answer,
            'intent'        => 'status_check',
            'sources'       => [],
            'quick_replies' => ['Required documents', 'Processing time', 'Contact helpline'],
            'tokens'        => 0,
        ];
    }

    /**
     * Classify intent using keyword matching — zero API calls
     */
    protected function classifyIntent(string $query): string
    {
        $query = strtolower($query);

        $patterns = [
            'status_check'  => ['status', 'track', 'reference', 'ref no', 'psk-', 'my application', 'applied', 'check my'],
            'documents'     => ['document', 'required', 'certificate', 'proof', 'aadhaar', 'attach'],
            'process_time'  => ['how long', 'days', 'time', 'when', 'duration', 'deadline'],
            'fee'           => ['fee', 'cost', 'charge', 'payment', 'price', 'how much'],
            'eligibility'   => ['eligible', 'qualify', 'criteria', 'who can', 'requirement'],
            'service_info'  => ['service', 'scheme', 'apply', 'how to', 'procedure'],
            'location'      => ['near', 'address', 'center', 'office', 'where', 'location'],
            'contact'       => ['contact', 'phone', 'helpline', 'email', 'support'],
        ];

        foreach ($patterns as $intent => $keywords) {
            foreach ($keywords as $keyword) {
                if (str_contains($query, $keyword)) {
                    return $intent;
                }
            }
        }

        return 'general';
    }

    /**
     * Source types per intent
     */
    protected function getSourceTypesForIntent(string $intent): array
    {
        return match($intent) {
            'documents'    => ['service', 'document', 'faq'],
            'process_time' => ['service', 'faq'],
            'fee'          => ['service', 'faq'],
            'eligibility'  => ['service', 'scheme', 'faq'],
            'location'     => ['faq', 'service'],
            'contact'      => ['faq'],
            default        => ['service', 'faq', 'scheme', 'document', 'blog'],
        };
    }

    /**
     * Load last N messages from DB
     */
    protected function getConversationHistory(ChatSession $session): array
    {
        $maxHistory = config('chatbot.rag_max_history', 8);

        return ChatMessage::where('session_id', $session->id)
            ->orderByDesc('created_at')
            ->limit($maxHistory)
            ->get(['role', 'content'])
            ->reverse()
            ->map(fn($m) => ['role' => $m->role, 'content' => $m->content])
            ->values()
            ->toArray();
    }

    /**
     * Build the RAG prompt
     */
    protected function buildPrompt(
        string $query,
        array  $chunks,
        array  $history,
        string $language,
        string $intent,
    ): string {
        $langInstruction = match($language) {
            'hi'    => 'Respond entirely in Hindi.',
            'pa'    => 'Respond entirely in Punjabi (Gurmukhi script).',
            default => 'Respond in English.',
        };

        $contextText = collect($chunks)
            ->map(fn($c, $i) => "[Source " . ($i + 1) . " – {$c['source_type']}]\n{$c['content']}")
            ->implode("\n\n");

        if (empty(trim($contextText))) {
            $contextText = '[No matching knowledge base entries found for this query.]';
        }

        $historyText = collect($history)
            ->map(fn($m) => strtoupper($m['role']) . ": " . $m['content'])
            ->implode("\n");

        $helpline  = config('chatbot.helpline', '1800-180-xxxx');
        $brandName = config('chatbot.brand_name', 'Punjab Seva Kendra');

        return <<<PROMPT
You are the official AI assistant for {$brandName} — a Government of Punjab digital services platform.
Your role is to help citizens with government services, schemes, documents, fees, eligibility, and application status.

LANGUAGE INSTRUCTION: {$langInstruction}

RULES:
- Answer ONLY from the provided context below. Do not make up information.
- Be concise, warm, and professional — like an official government assistant.
- If the answer is not in the context, say you don't have that information and suggest calling the helpline: {$helpline}.
- Format lists with bullet points for clarity.
- Never share personal opinions or political content.
- Intent detected: {$intent}

=== KNOWLEDGE CONTEXT ===
{$contextText}

=== CONVERSATION HISTORY ===
{$historyText}

=== USER QUESTION ===
{$query}

=== YOUR ANSWER ===
PROMPT;
    }

    /**
     * Build source citations
     */
    protected function buildSources(array $chunks): array
    {
        return collect($chunks)
            ->unique('source_id')
            ->take(3)
            ->map(fn($c) => [
                'type'  => $c['source_type'],
                'title' => $c['title'] ?? '',
                'id'    => $c['source_id'],
            ])
            ->values()
            ->toArray();
    }

    /**
     * Quick reply suggestions
     */
    protected function generateQuickReplies(string $intent, string $language): array
    {
        $replies = match($intent) {
            'service_info'  => ['Required documents', 'Processing time', 'Application fee', 'How to apply'],
            'documents'     => ['Where to submit?', 'Self-attested copies?', 'Document checklist'],
            'process_time'  => ['Track my application', 'Expedite process', 'Contact office'],
            'status_check'  => ['Required documents', 'Contact helpline', 'Visit nearest center'],
            'location'      => ['Working hours', 'Contact number', 'Services available'],
            default         => ['Popular services', 'Check application status', 'Helpline number', 'Required documents'],
        };

        if ($language === 'hi') {
            $replies = match($intent) {
                'service_info' => ['आवश्यक दस्तावेज़', 'प्रसंस्करण समय', 'आवेदन शुल्क'],
                'status_check' => ['हेल्पलाइन से संपर्क करें', 'नजदीकी केंद्र जाएं'],
                default        => ['लोकप्रिय सेवाएं', 'आवेदन स्थिति जांचें', 'हेल्पलाइन नंबर'],
            };
        }
        elseif ($language === 'pa') {
            $replies = match($intent) {
                'service_info' => ['ਲੋੜੀਂਦੇ ਦਸਤਾਵੇਜ਼', 'ਪ੍ਰਕਿਰਿਆ ਸਮਾਂ', 'ਆਵेदन ਫੀਸ'],
                'status_check' => ['ਹੈਲਪਲਾਈਨ ਨਾਲ ਸੰਪਰਕ ਕਰੋ', 'ਨਜ਼ਦੀਕੀ ਕੇਂਦਰ ਜਾਓ'],
                default        => ['ਪ੍ਰਸਿੱਧ ਸੇਵਾਵਾਂ', 'ਆਵेदन ਸਥਿਤੀ ਚੈੱਕ ਕਰੋ', 'ਹੈਲਪਲਾਈਨ ਨੰਬਰ'],
            };
        }

        return array_slice($replies, 0, 4);
    }
}