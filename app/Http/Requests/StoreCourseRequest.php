<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $courseId = $this->route('course')?->id;
        $universityId = auth()->user()->university_id;

        return [
            'title' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:255', 'unique:courses,code'.($courseId ? ','.$courseId.',id' : ',NULL,id').',university_id,'.$universityId],
            'semester' => ['required', 'string', 'max:255'],
            'credit_hours' => ['required', 'integer', 'min:1', 'max:6'],
            'department' => ['required', 'string', 'max:255'],
        ];
    }
}
