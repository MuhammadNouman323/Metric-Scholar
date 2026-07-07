<?php

namespace App\Repositories;

use App\Models\Feedback;
use App\Models\FeedbackAnswer;
use App\Models\FeedbackToken;

class FeedbackRepository
{
    public function findToken(string $tokenUuid): ?FeedbackToken
    {
        return FeedbackToken::where('token', $tokenUuid)->first();
    }

    public function markTokenAsUsed(FeedbackToken $token): void
    {
        $token->update([
            'is_used' => true,
            'used_at' => now(),
        ]);
    }

    public function saveFeedback(array $feedbackData, array $answersData): Feedback
    {
        $feedback = Feedback::create([
            'evaluation_id' => $feedbackData['evaluation_id'],
            'faculty_id' => $feedbackData['faculty_id'],
            'course_id' => $feedbackData['course_id'],
        ]);

        foreach ($answersData as $questionId => $answer) {
            FeedbackAnswer::create([
                'feedback_id' => $feedback->id,
                'question_id' => $questionId,
                'rating' => $answer['rating'] ?? null,
                'text_answer' => $answer['text_answer'] ?? null,
            ]);
        }

        return $feedback;
    }
}
