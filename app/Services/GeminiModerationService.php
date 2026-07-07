<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GeminiModerationService
{
    public function moderate(string $comment): array
    {
        $prompt = <<<PROMPT
You are an AI moderator for a university faculty evaluation system.

Analyze this anonymous student feedback.

Rules:

- Detect profanity
- Detect hate speech
- Detect harassment
- Detect bullying
- Detect racism
- Detect sexism
- Detect threats
- Detect offensive language
- Detect spam
- Detect meaningless text
- Detect excessive slang

DO NOT reject constructive criticism.

Examples of GOOD feedback:

"The instructor explained concepts clearly."

"The labs should have more practical exercises."

"The grading rubric needs improvement."

Examples of BAD feedback:

"The teacher is stupid."

"I hate this teacher."

Return ONLY valid JSON.

Format:

{
"status":"approved|flagged|rejected",
"toxicity_score":0,
"reason":"",
"cleaned_comment":""
}

Comment:

$comment
PROMPT;

        $response = Http::timeout(30)
            ->post(
                'https://generativelanguage.googleapis.com/v1beta/models/'.
                config('services.gemini.model').
                ':generateContent?key='.
                config('services.gemini.api_key'),
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
                ]
            );

        if (! $response->successful()) {
            throw new \Exception('Gemini API Error');
        }

        $text = data_get(
            $response->json(),
            'candidates.0.content.parts.0.text'
        );

        $json = json_decode($text, true);

        if (! $json) {
            throw new \Exception('Invalid Gemini JSON Response');
        }

        return $json;
    }
}
