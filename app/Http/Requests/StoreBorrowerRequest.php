<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBorrowerRequest extends FormRequest
{
    // Allow all users to hit this endpoint for now; adapt if auth required.
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:borrowers,email',
            // phone: allow numeric-like strings and common phone chars (+, -, spaces, parentheses)
            'phone' => ['required', 'string', 'max:50', 'regex:/^[0-9+\-\s\(\)]+$/'],
            // status is optional; default handled in service/model/migration
            'status' => 'nullable|string|in:active,inactive,pending',
        ];
    }


    public function messages(): array
    {
        return [
            'phone.regex' => 'Phone may only contain digits, spaces and the characters + - ( ).',
        ];
    }
}
