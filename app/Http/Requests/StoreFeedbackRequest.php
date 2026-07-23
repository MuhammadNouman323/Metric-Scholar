<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFeedbackRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'token' => 'required|string|exists:feedback_tokens,token',
            'clarity' => 'required|integer|min:1|max:5',
            'materials' => 'required|integer|min:1|max:5',
            'responsiveness' => 'required|integer|min:1|max:5',
            'fairness' => 'required|integer|min:1|max:5',
            'practical' => 'required|integer|min:1|max:5',
            'organization' => 'required|integer|min:1|max:5',
            'overall_rating' => 'required|integer|min:1|max:5',
            'comments' => 'nullable|string|max:2000',
            'what_worked_well' => 'nullable|string|max:2000',
            'what_could_improve' => 'nullable|string|max:2000',
            'recommendation' => 'nullable|in:yes_definitely,neutral,not_really',
        ];
    }
}
