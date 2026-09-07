<?php

namespace App\Http\Requests;

use App\Enums\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $adminDomain = explode('@', $this->user()->email)[1];

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'bail', 'required', 'string', 'email', 'max:255', 'unique:users,email',
                function (string $attribute, mixed $value, \Closure $fail) use ($adminDomain) {
                    $inputDomain = explode('@', $value)[1] ?? null;
                    if ($inputDomain !== $adminDomain) {
                        $fail('The email domain must match your institutional domain ('.$adminDomain.').');
                    }
                },
            ],
            'role' => ['required', 'in:'.implode(',', [Role::Student->value, Role::Faculty->value])],
            'department' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'confirmed', Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
            'password_confirmation' => ['required', 'string'],
        ];
    }
}
