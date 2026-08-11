<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Gemini API Configuration
    |--------------------------------------------------------------------------
    */
    'groq_api_key' => env('GROQ_API_KEY'),
    'groq_model'   => env('GROQ_MODEL', 'llama-3.1-8b-instant'),
    'gemini_api_key'     => env('GEMINI_API_KEY'),
    'gemini_model'       => env('GEMINI_MODEL', 'gemini-1.5-pro'),
    // ✅ renamed from 'embed_model' → 'gemini_embed_model' to match GeminiService
    'gemini_embed_model' => env('GEMINI_EMBED_MODEL', 'text-embedding-004'),

    /*
    |--------------------------------------------------------------------------
    | RAG Pipeline Settings — flattened so services can read them directly
    |--------------------------------------------------------------------------
    */
    // ✅ these were nested under 'rag' => [] — flattened to match service calls
    'rag_top_k'          => env('RAG_TOP_K', 6),
    'rag_min_similarity' => env('RAG_MIN_SIMILARITY', 0.55),  // lowered from 0.60
    'rag_max_history'    => env('RAG_MAX_HISTORY', 8),
    'rag_cache_ttl'      => env('RAG_CACHE_TTL', 300),
    'rag_embedding_dim'  => 768,

    /*
    |--------------------------------------------------------------------------
    | Session Settings — flattened to match controller calls
    |--------------------------------------------------------------------------
    */
    // ✅ was nested 'session' => ['ttl_hours'] — flattened to 'session_ttl'
    'session_ttl'        => env('CHATBOT_SESSION_TTL', 2),
    'session_max_messages' => env('CHATBOT_MAX_MESSAGES', 100),

    /*
    |--------------------------------------------------------------------------
    | Rate Limiting
    |--------------------------------------------------------------------------
    */
    'rate_guest'         => env('CHATBOT_RATE_GUEST', 30),
    'rate_user'          => env('CHATBOT_RATE_USER', 60),

    /*
    |--------------------------------------------------------------------------
    | Supported Languages
    |--------------------------------------------------------------------------
    */
    'languages' => [
        'en' => 'English',
        'hi' => 'Hindi',
        'pa' => 'Punjabi',
    ],

    /*
    |--------------------------------------------------------------------------
    | Knowledge Source Types
    |--------------------------------------------------------------------------
    */
    'source_types' => ['service', 'faq', 'document', 'scheme', 'blog'],

    /*
    |--------------------------------------------------------------------------
    | Branding
    |--------------------------------------------------------------------------
    */
    'brand_name' => env('CHATBOT_BRAND', 'Punjab Seva Kendra'),
    'helpline'   => env('CHATBOT_HELPLINE', '1800-180-xxxx'),

    /*
    |--------------------------------------------------------------------------
    | Queue Settings
    |--------------------------------------------------------------------------
    */
    'queues' => [
        'embeddings' => env('QUEUE_EMBEDDINGS', 'embeddings'),
        'analytics'  => env('QUEUE_ANALYTICS', 'analytics'),
        'default'    => env('QUEUE_DEFAULT', 'default'),
    ],

];