<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiModerationService
{
    /**
     * Moderate student feedback using Gemini AI with fallback to a local filter.
     */
    public function moderate(string $comment): array
    {
        if (blank($comment)) {
            return [
                'status' => 'approved',
                'toxicity_score' => 0,
                'reason' => 'Empty comment',
                'categories' => [],
                'cleaned_comment' => $comment,
            ];
        }

        $apiKey = config('services.gemini.api_key');
        $model = config('services.gemini.model', 'gemini-1.5-flash');

        if (blank($apiKey)) {
            Log::warning('Gemini API key is not set. Falling back to local moderation filter.');

            return $this->localModerate($comment);
        }

        $prompt = $this->buildPrompt($comment);

        $attempts = 3;
        $delayMs = 500;

        for ($attempt = 1; $attempt <= $attempts; $attempt++) {
            try {
                $response = Http::timeout(10)
                    ->post(
                        "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}",
                        [
                            'contents' => [
                                [
                                    'parts' => [
                                        [
                                            'text' => $prompt,
                                        ],
                                    ],
                                ],
                            ],
                            'generationConfig' => [
                                'responseMimeType' => 'application/json',
                            ],
                        ]
                    );

                if ($response->successful()) {
                    $text = data_get($response->json(), 'candidates.0.content.parts.0.text');
                    $json = $this->parseJson($text);
                    if ($json && $this->isValidModerationResult($json)) {
                        return [
                            'status' => $json['status'],
                            'toxicity_score' => $this->normalizeToxicityScore($json['toxicity_score'] ?? 0),
                            'reason' => $json['reason'] ?? '',
                            'categories' => $json['categories'] ?? [],
                            'cleaned_comment' => $json['cleaned_comment'] ?? $comment,
                        ];
                    }
                    Log::warning("Gemini returned malformed JSON on attempt {$attempt}: ".$text);
                } else {
                    Log::warning("Gemini API call failed on attempt {$attempt}. Status: ".$response->status().' Body: '.$response->body());
                }
            } catch (\Exception $e) {
                Log::error("Gemini API Exception on attempt {$attempt}: ".$e->getMessage());
            }

            if ($attempt < $attempts) {
                usleep($delayMs * 1000);
                $delayMs *= 2; // Exponential backoff
            }
        }

        Log::error("Gemini AI Moderation failed after {$attempts} attempts. Falling back to local filter.");

        return $this->localModerate($comment);
    }

    /**
     * Local moderation fallback filter.
     */
    public function localModerate(string $comment): array
    {
        $lower = strtolower($comment);

        // Common profanities, slurs, and insults to reject
        $rejectedWords = [
            'idiot', 'stupid', 'hate', 'kill', 'die', 'bastard', 'fuck', 'shit', 'asshole', 'bitch', 'cunt',
            'trash', 'useless', 'worst', 'dumb', 'clown', 'garbage', 'retard', 'whore', 'faggot',
        ];

        // Milder slang words that should be flagged and cleaned
        $flaggedWords = [
            'crap', 'sucks', 'hell', 'damn', 'piss', 'frustrated',
        ];

        $trimmed = trim($comment);
        if (strlen($trimmed) < 4) {
            return [
                'status' => 'rejected',
                'toxicity_score' => 90,
                'reason' => 'Feedback is extremely short or meaningless.',
                'categories' => ['meaningless'],
                'cleaned_comment' => $comment,
            ];
        }

        $matchedRejected = [];
        foreach ($rejectedWords as $word) {
            if (preg_match('/\b'.preg_quote($word, '/').'\b/i', $lower)) {
                $matchedRejected[] = 'offensive_language';
            }
        }

        if (! empty($matchedRejected)) {
            // Graduated score: base severity plus escalation for each extra match.
            $score = min(85 + (count($matchedRejected) - 1) * 2, 95);

            return [
                'status' => 'rejected',
                'toxicity_score' => $score,
                'reason' => 'Feedback contains abusive, offensive, or inappropriate language.',
                'categories' => array_unique($matchedRejected),
                'cleaned_comment' => $comment,
            ];
        }

        $matchedFlagged = [];
        $cleaned = $comment;
        foreach ($flaggedWords as $word) {
            if (preg_match('/\b'.preg_quote($word, '/').'\b/i', $lower)) {
                $matchedFlagged[] = 'slang';
                $cleaned = preg_replace('/\b'.preg_quote($word, '/').'\b/i', str_repeat('*', strlen($word)), $cleaned);
            }
        }

        if (! empty($matchedFlagged)) {
            // Graduated score: single mild slang word scores low, repeated
            // slang escalates, but never reaches the rejected range.
            $score = min(30 + (count($matchedFlagged) - 1) * 5, 60);

            return [
                'status' => 'flagged',
                'toxicity_score' => $score,
                'reason' => 'Feedback contains mild slang or informal language.',
                'categories' => array_unique($matchedFlagged),
                'cleaned_comment' => $cleaned,
            ];
        }

        return [
            'status' => 'approved',
            'toxicity_score' => 0,
            'reason' => 'Feedback is constructive and appropriate.',
            'categories' => [],
            'cleaned_comment' => $comment,
        ];
    }

    /**
     * Build the prompt for Gemini.
     */
    private function buildPrompt(string $comment): string
    {
        return <<<PROMPT
You are an AI moderator for a university faculty evaluation system.

Analyze this anonymous student feedback.

Evaluate the comment against these categories:
- hate_speech
- profanity
- offensive_language
- slang
- harassment
- bullying
- racism
- religious_hate
- sexism
- personal_attacks
- threats
- toxic_language
- spam
- gibberish
- non_academic
- meaningless

Rules:
1. DO NOT reject constructive criticism or negative opinions if they are phrased respectfully.
2. If the text has high toxicity, profanity, racism, sexism, direct attacks, or threats, set status to "rejected".
3. If the text contains mild slang, inappropriate informal language, or words that can be cleaned, set status to "flagged".
4. If the text is constructive, normal academic discussion, or reasonable critique, set status to "approved".
5. Return ONLY a valid JSON object. Do not include markdown code block formatting.

Response Format:
{
  "status": "approved|flagged|rejected",
  "toxicity_score": <integer from 0 to 100>,
  "reason": "<short explanation of the moderation action>",
  "categories": ["<category_name>", ...],
  "cleaned_comment": "<cleaned version of the comment if flagged (replacing offensive/slang words with asterisks or neutral terms), otherwise same as input>"
}

Feedback:
"$comment"
PROMPT;
    }

    /**
     * Safely parse JSON text from Gemini.
     */
    private function parseJson(?string $text): ?array
    {
        if (blank($text)) {
            return null;
        }

        $text = trim($text);
        if (str_starts_with($text, '```json')) {
            $text = substr($text, 7);
        } elseif (str_starts_with($text, '```')) {
            $text = substr($text, 3);
        }
        if (str_ends_with($text, '```')) {
            $text = substr($text, 0, -3);
        }
        $text = trim($text);

        return json_decode($text, true);
    }

    /**
     * Validate that a parsed moderation result has an allowed status.
     */
    private function isValidModerationResult(array $json): bool
    {
        return in_array($json['status'] ?? null, ['approved', 'flagged', 'rejected'], true);
    }

    /**
     * Coerce the toxicity score to an integer clamped to 0-100.
     */
    private function normalizeToxicityScore(mixed $score): int
    {
        return max(0, min(100, (int) round(is_numeric($score) ? (float) $score : 0)));
    }
}
