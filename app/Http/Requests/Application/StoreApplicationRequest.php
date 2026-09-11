<?php

namespace App\Http\Requests\Application;

use App\Support\Security;
use Illuminate\Foundation\Http\FormRequest;

class StoreApplicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('cover_letter')) {
            $this->merge([
                'cover_letter' => Security::cleanInput($this->cover_letter),
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'cover_letter' => ['nullable', 'string', 'max:5000'],
        ];
    }
}
