<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CurrencyRateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'from' => 'required|string|size:3',
            'to' => 'required|string|size:3',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'from' => strtoupper($this->input('from')),
            'to' => strtoupper($this->input('to')),
        ]);
    }
}
