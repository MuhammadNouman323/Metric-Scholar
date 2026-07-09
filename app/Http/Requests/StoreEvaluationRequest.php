<?php

namespace App\Http\Requests;

use App\Models\Evaluation;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreEvaluationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'semester' => ['required', 'string', 'max:255'],
            'evaluation_type' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'is_anonymous' => ['boolean'],
            'allow_faculty_response' => ['boolean'],
            'send_reminder' => ['boolean'],
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (Evaluation::whereIn('status', ['active', 'scheduled'])->exists()) {
                $validator->errors()->add(
                    'status',
                    'Another evaluation cycle is already scheduled or active. Please wait until the current evaluation cycle is completed before creating a new one.'
                );
            }
        });
    }
}
