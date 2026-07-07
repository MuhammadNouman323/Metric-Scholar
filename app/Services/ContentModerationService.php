<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ContentModerationService
{
    protected string $apiKey;

    protected string $endpoint;

    public function __construct()
    {
        $this->apiKey = config('services.gemini.key') ?? env('GEMINI_API_KEY');
        // Using gemini-2.5-flash as it is fast and cheap for text tasks
        $this->endpoint = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$this->apiKey}";
    }

    /**
     * Moderates the text and returns an array with the structured outcome.
     */
    public function moderate(string $text): array
    {
        $systemInstruction = "You are an AI content moderator. Analyze the user's input text based on these rules:
        1. Hate speech or severe Offensive language: Mark as inappropriate, set reason to 'Hate speech', and set suggested_text to '[Content Removed]'.
        2. Minor Offensive language: Mark as inappropriate, set reason to 'Offensive language', but provide a polite, cleaned-up version in suggested_text.
        3. Spam (links, scams): Mark as inappropriate, set reason to 'Spam', and set suggested_text to '[Spam Filtered]'.
        4. Very short/low-effort comments (e.g., 'Bad', 'Okay', 'Worst'): Mark as inappropriate, set reason to 'Too short/Low effort', and suggested_text to ''.
        5. Safe text: Mark as appropriate, set reason to 'None', and keep suggested_text identical to the input.";

        // Define the JSON schema we want Gemini to return
        $jsonSchema = [
            'type' => 'OBJECT',
            'properties' => [
                'is_appropriate' => ['type' => 'BOOLEAN'],
                'reason' => ['type' => 'STRING'],
                'suggested_text' => ['type' => 'STRING'],
            ],
            'required' => ['is_appropriate', 'reason', 'suggested_text'],
        ];

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post($this->endpoint, [
                'contents' => [
                    'parts' => [
                        ['text' => $text],
                    ],
                ],
                'systemInstruction' => [
                    'parts' => [
                        ['text' => $systemInstruction],
                    ],
                ],
                'generationConfig' => [
                    'responseMimeType' => 'application/json',
                    'responseSchema' => $jsonSchema,
                    'temperature' => 0.1, // Keep it deterministic
                ],
            ]);

            if ($response->successful()) {
                $resultJson = $response->json('candidates.0.content.parts.0.text');

                return json_decode($resultJson, true);
            }

            Log::error('Gemini API Error: '.$response->body());
        } catch (\Exception $e) {
            Log::error('Gemini Service Exception: '.$e->getMessage());
        }

        // Fallback if API fails (let it pass through as safe to avoid breaking your app)
        return [
            'is_appropriate' => true,
            'reason' => 'API_FAILURE_FALLBACK',
            'suggested_text' => $text,
        ];
    }
}
