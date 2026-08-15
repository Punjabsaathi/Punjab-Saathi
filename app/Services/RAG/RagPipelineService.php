<?php

namespace App\Services\RAG;

use App\Models\ChatMessage;
use App\Models\ChatSession;
use App\Models\Service;
use App\Models\ServiceApplication;
use App\Services\AI\GeminiService;
use App\Services\Embedding\EmbeddingService;
use App\Services\RAG\VectorSearchService;
use Illuminate\Support\Facades\Cache;

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

        // Step 2b: "View services" / "Popular services" style navigational
        // quick-replies are exact known button labels, not real questions —
        // there's no single knowledge chunk that represents "the full list
        // of services" (every chunk is about one specific service), so
        // vector search never scores any of them above the similarity
        // threshold for this generic phrasing. Handle it directly instead
        // of letting it fall through to the "no information" fallback.
        if ($this->isBrowseServicesQuery($query)) {
            return $this->handleBrowseServices($language);
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

        // Step 6b: Nothing relevant retrieved — answer honestly without
        // burning a Groq/Gemini call, instead of hoping the LLM follows
        // the "don't hallucinate" rule on an empty context.
        if (empty($chunks)) {
            $result = [
                'answer'         => $this->noInformationResponse($language),
                'intent'         => $intent,
                'sources'        => [],
                'quick_replies'  => $this->generateQuickReplies($intent, $language),
                'tokens'         => 0,
                'provider'       => null,
                'chunks_count'   => 0,
                'top_similarity' => null,
            ];

            Cache::put($cacheKey, $result, config('chatbot.rag_cache_ttl', 300));

            return $result;
        }

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

        // Step 9: Generate response (Groq primary, Gemini fallback)
        $geminiResponse = $this->gemini->generate($prompt);

        // Step 10: Build response
        $sources      = $this->buildSources($chunks);
        $quickReplies = $this->generateQuickReplies($intent, $language);

        $result = [
            'answer'         => $geminiResponse['text'],
            'intent'         => $intent,
            'sources'        => $sources,
            'quick_replies'  => $quickReplies,
            'tokens'         => $geminiResponse['tokens'] ?? 0,
            'provider'       => $geminiResponse['provider'] ?? 'groq',
            'chunks_count'   => count($chunks),
            'top_similarity' => $chunks[0]['similarity'] ?? null,
        ];

        Cache::put($cacheKey, $result, config('chatbot.rag_cache_ttl', 300));

        return $result;
    }

    /**
     * Localized "nothing found" response, used when retrieval returns
     * zero chunks above the similarity threshold.
     */
    protected function noInformationResponse(string $language): string
    {
        $helpline = config('chatbot.helpline', '1800-180-xxxx');

        return match($language) {
            'hi' => "मुझे इसके बारे में विशिष्ट जानकारी नहीं है। कृपया सेवाओं, फॉर्म, नौकरियों या ब्लॉग के बारे में पूछें, या हमारी हेल्पलाइन पर कॉल करें: {$helpline}",
            'pa' => "ਮੈਨੂੰ ਇਸ ਬਾਰੇ ਖਾਸ ਜਾਣਕਾਰੀ ਨਹੀਂ ਹੈ। ਕਿਰਪਾ ਕਰਕੇ ਸੇਵਾਵਾਂ, ਫਾਰਮਾਂ, ਨੌਕਰੀਆਂ ਜਾਂ ਬਲੌਗ ਬਾਰੇ ਪੁੱਛੋ, ਜਾਂ ਸਾਡੀ ਹੈਲਪਲਾਈਨ 'ਤੇ ਕਾਲ ਕਰੋ: {$helpline}",
            default => "I don't have specific information on that. Try asking about services, forms, jobs, or blog articles, or call our helpline: {$helpline}",
        };
    }

    /**
     * Handle application status check — pure MySQL, zero AI calls (except
     * translation of the final answer, which itself now falls back
     * Groq→Gemini transparently).
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
                'provider'      => null,
            ];
        }

        // Look up application in DB via Eloquent so casts (admin_notes as
        // array, created_at/updated_at as Carbon) and the service relation
        // apply automatically.
        $application = ServiceApplication::with('service')
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
                'provider'      => null,
            ];
        }

        $serviceName = $application->service->title ?? 'Government Service';

        // Format status nicely — matches the real service_applications
        // status enum: pending, in_review, processing, completed, rejected.
        $statusLabel = match($application->status) {
            'pending'    => '🟡 Pending — Your application is received and awaiting review.',
            'in_review'  => '🔵 In Review — Your application is currently being reviewed by our team.',
            'processing' => '🔵 Processing — Your application is being processed.',
            'completed'  => '✅ Completed — Your service has been delivered.',
            'rejected'   => '❌ Rejected — Your application was not approved.',
            default      => ucfirst($application->status),
        };

        // admin_notes is a JSON array of {status, note} history entries —
        // surface the note only if it belongs to the current status,
        // mirroring ServiceApplication::toStatusChangeData()'s logic.
        $note = null;
        $notes = $application->admin_notes ?? [];
        if (!empty($notes)) {
            $lastEntry = end($notes);
            if (($lastEntry['status'] ?? null) === $application->status) {
                $note = $lastEntry['note'] ?? null;
            }
        }

        $submittedDate = $application->created_at?->format('d M Y') ?? 'N/A';
        $updatedDate   = $application->updated_at?->format('d M Y') ?? 'N/A';

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
            $note ? "\n📝 **Note from our team:** {$note}" : null,
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
            'provider'      => null,
        ];
    }

    /**
     * Known exact button labels (all languages, all the places the widget
     * emits them: the JS greeting's quick-replies and this service's own
     * generateQuickReplies()) that mean "show me the services list" rather
     * than being a real natural-language question.
     */
    protected function isBrowseServicesQuery(string $query): bool
    {
        $normalized = mb_strtolower(trim($query));

        return in_array($normalized, [
            'view services',
            'popular services',
            'services available',
            'सेवाएं देखें',
            'लोकप्रिय सेवाएं',
            'ਸੇਵਾਵਾਂ ਵੇਖੋ',
            'ਪ੍ਰਸਿੱਧ ਸੇਵਾਵਾਂ',
        ], true);
    }

    /**
     * Direct, deterministic list of services — bypasses embedding search
     * and the LLM entirely since this isn't a question that needs
     * reasoning over retrieved context, just a real list + a link.
     */
    protected function handleBrowseServices(string $language): array
    {
        $services = Service::where('is_active', true)
            ->orderByDesc('is_popular')
            ->orderBy('title')
            ->limit(8)
            ->get(['title', 'slug']);

        $servicesUrl = route('services.index');

        if ($services->isEmpty()) {
            $answer = "You can view all our services at {$servicesUrl}.";
        } else {
            $list = $services->map(fn($s) => "• {$s->title}")->implode("\n");
            $answer = "Here are some of our services:\n\n{$list}\n\nSee the full list at {$servicesUrl}.";
        }

        if ($language !== 'en') {
            $answer = $this->gemini->translate($answer, $language);
        }

        return [
            'answer'        => $answer,
            'intent'        => 'service_info',
            'sources'       => [],
            'quick_replies' => ['Required documents', 'Processing time', 'Application fee'],
            'tokens'        => 0,
            'provider'      => null,
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
            'documents'    => ['service', 'document', 'faq', 'form', 'job'],
            'process_time' => ['service', 'faq', 'job'],
            'fee'          => ['service', 'faq', 'job'],
            'eligibility'  => ['service', 'scheme', 'faq', 'job'],
            // "where" is a common trigger for this intent but isn't
            // exclusively about physical location — "where can I
            // download/apply/find X" is a common phrasing too, so these
            // stay broad rather than assuming every match is literally
            // an office-address question.
            'location'     => ['faq', 'service', 'form', 'job'],
            'contact'      => ['faq', 'service'],
            default        => ['service', 'faq', 'scheme', 'document', 'blog', 'form', 'job'],
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

        $langShort = match($language) {
            'hi'    => 'Hindi',
            'pa'    => 'Punjabi (Gurmukhi script)',
            default => 'English',
        };

        $contextText = collect($chunks)
            ->map(fn($c, $i) => "[Source " . ($i + 1) . " – {$c['source_type']}]\n{$c['content']}")
            ->implode("\n\n");

        if (empty(trim($contextText))) {
            $contextText = '[No matching knowledge base entries found for this query.]';
        } elseif (mb_strlen($contextText) > 6000) {
            // Token-budget guard — up to 6 chunks concatenated has no
            // upper bound otherwise, and could crowd out the response
            // budget (max_tokens) on the prompt side.
            $contextText = mb_substr($contextText, 0, 6000) . '…';
        }

        $historyText = collect($history)
            ->map(fn($m) => strtoupper($m['role']) . ": " . $m['content'])
            ->implode("\n");

        $helpline  = config('chatbot.helpline', '1800-180-xxxx');
        $brandName = config('chatbot.brand_name', 'Punjab Saathi');
        $website   = config('site.website', 'https://punjabsaathi.in');

        return <<<PROMPT
You are the AI assistant for {$brandName} — a private Common Service Centre (CSC) assistance
platform that helps citizens navigate official government portals in Punjab. {$brandName} is
NOT a government office or a government website — do not describe it, or imply it is, an
official government platform, and never invent or reference a ".gov.in" domain for it.
The only real website for {$brandName} is {$website} — never state, imply, or invent any other
domain or URL for it.

Your role is to help citizens with government services, schemes, documents, fees, eligibility, and application status.

LANGUAGE INSTRUCTION: {$langInstruction}

RULES:
- Answer ONLY from the provided context below. Do not make up information.
- If a source in the context below includes a "URL:" line, and it's directly relevant to the
  question, include that exact URL in your answer so the user can click straight through —
  don't just tell them to "search the website" when you already have the real link.
- Never invent a URL, link, page path, or navigation menu item. Only ever use a URL that
  appears verbatim in the context below — if none is present, do not include any link at all,
  and instead tell the user what to search for or ask for on the website.
- Be concise, warm, and professional — like a trusted assistant, not a government official.
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

IMPORTANT: Your entire answer must be in {$langShort}, regardless of the language used in the context above.
IMPORTANT: Only use a URL if it appears verbatim above as a "URL:" line — never invent one, and never use a ".gov.in" domain.

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
            'eligibility'   => ['Required documents', 'How to apply', 'Application fee'],
            'location'      => ['Working hours', 'Contact number', 'Services available'],
            'contact'       => ['Working hours', 'Nearest center', 'Popular services'],
            default         => ['Popular services', 'Check application status', 'Helpline number', 'Required documents'],
        };

        if ($language === 'hi') {
            $replies = match($intent) {
                'service_info' => ['आवश्यक दस्तावेज़', 'प्रसंस्करण समय', 'आवेदन शुल्क'],
                'documents'    => ['कहां जमा करें?', 'स्व-सत्यापित प्रतियां?', 'दस्तावेज़ सूची'],
                'process_time' => ['आवेदन ट्रैक करें', 'प्रक्रिया में तेजी लाएं', 'कार्यालय से संपर्क करें'],
                'status_check' => ['हेल्पलाइन से संपर्क करें', 'नजदीकी केंद्र जाएं'],
                'eligibility'  => ['आवश्यक दस्तावेज़', 'आवेदन कैसे करें', 'आवेदन शुल्क'],
                'location'     => ['कार्य के घंटे', 'संपर्क नंबर', 'उपलब्ध सेवाएं'],
                'contact'      => ['कार्य के घंटे', 'नजदीकी केंद्र', 'लोकप्रिय सेवाएं'],
                default        => ['लोकप्रिय सेवाएं', 'आवेदन स्थिति जांचें', 'हेल्पलाइन नंबर'],
            };
        }
        elseif ($language === 'pa') {
            $replies = match($intent) {
                'service_info' => ['ਲੋੜੀਂਦੇ ਦਸਤਾਵੇਜ਼', 'ਪ੍ਰਕਿਰਿਆ ਸਮਾਂ', 'ਆਵੇਦਨ ਫੀਸ'],
                'documents'    => ['ਕਿੱਥੇ ਜਮ੍ਹਾਂ ਕਰੀਏ?', 'ਸਵੈ-ਤਸਦੀਕਸ਼ੁਦਾ ਕਾਪੀਆਂ?', 'ਦਸਤਾਵੇਜ਼ ਸੂਚੀ'],
                'process_time' => ['ਆਵੇਦਨ ਟਰੈਕ ਕਰੋ', 'ਪ੍ਰਕਿਰਿਆ ਤੇਜ਼ ਕਰੋ', 'ਦਫ਼ਤਰ ਨਾਲ ਸੰਪਰਕ ਕਰੋ'],
                'status_check' => ['ਹੈਲਪਲਾਈਨ ਨਾਲ ਸੰਪਰਕ ਕਰੋ', 'ਨਜ਼ਦੀਕੀ ਕੇਂਦਰ ਜਾਓ'],
                'eligibility'  => ['ਲੋੜੀਂਦੇ ਦਸਤਾਵੇਜ਼', 'ਅਰਜ਼ੀ ਕਿਵੇਂ ਦੇਈਏ', 'ਆਵੇਦਨ ਫੀਸ'],
                'location'     => ['ਕੰਮ ਦੇ ਘੰਟੇ', 'ਸੰਪਰਕ ਨੰਬਰ', 'ਉਪਲਬਧ ਸੇਵਾਵਾਂ'],
                'contact'      => ['ਕੰਮ ਦੇ ਘੰਟੇ', 'ਨਜ਼ਦੀਕੀ ਕੇਂਦਰ', 'ਪ੍ਰਸਿੱਧ ਸੇਵਾਵਾਂ'],
                default        => ['ਪ੍ਰਸਿੱਧ ਸੇਵਾਵਾਂ', 'ਆਵੇਦਨ ਸਥਿਤੀ ਚੈੱਕ ਕਰੋ', 'ਹੈਲਪਲਾਈਨ ਨੰਬਰ'],
            };
        }

        return array_slice($replies, 0, 4);
    }
}
