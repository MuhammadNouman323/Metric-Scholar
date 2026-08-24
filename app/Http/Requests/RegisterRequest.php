<?php

namespace App\Http\Requests;

use App\Enums\Role;
use App\Models\University;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Validator;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'department' => ['nullable', 'string', 'max:255'],
            'admin_id' => ['nullable', 'string', 'max:255', 'unique:users,admin_id'],
            'terms' => ['accepted'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            if ($validator->errors()->has('email')) {
                return;
            }

            $university = $this->resolveUniversity();

            if (! $university) {
                $validator->errors()->add(
                    'email',
                    'Your institution is not registered with us. Please contact support to have your university added.'
                );

                return;
            }

            $adminExists = User::query()
                ->where('university_id', $university->id)
                ->where('role', Role::Admin->value)
                ->exists();

            if ($adminExists) {
                $validator->errors()->add(
                    'email',
                    'An administrator account already exists for this institution. Please contact your existing administrator.'
                );
            }
        });
    }

    public function resolveUniversity(): ?University
    {
        $domain = strtolower(Str::afterLast((string) $this->input('email'), '@'));

        return University::query()->where('domain', $domain)->first();
    }
}
