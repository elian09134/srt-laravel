<?php

namespace App\Http\Requests\Admin;

use App\Support\Security;
use Illuminate\Foundation\Http\FormRequest;

class RejectFptkRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('admin_note')) {
            $this->merge(['admin_note' => Security::cleanInput($this->admin_note)]);
        }
    }

    public function rules(): array
    {
        return [
            'admin_note' => ['nullable', 'string', 'max:2000'],
        ];
    }
}
