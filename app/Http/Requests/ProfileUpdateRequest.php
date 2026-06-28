<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('no_whatsapp')) {
            $wa = preg_replace('/[^0-9]/', '', $this->no_whatsapp);
            if (str_starts_with($wa, '0')) {
                $wa = '62' . substr($wa, 1);
            } elseif (!str_starts_with($wa, '62')) {
                $wa = '62' . $wa;
            }
            $this->merge([
                'no_whatsapp' => '+' . $wa,
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'no_whatsapp' => ['required', 'string', 'max:20', 'regex:/^[0-9+\-\s]+$/'],
        ];
    }
}
