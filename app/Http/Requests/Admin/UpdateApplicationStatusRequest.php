<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateApplicationStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => [
                'required',
                'string',
                Rule::in([
                    'Baru',
                    'Lamaran Dilihat',
                    'Psikotest',
                    'Wawancara HR',
                    'Wawancara User',
                    'Offering Letter',
                    'Shortlist',
                    'Diterima',
                    'Tidak Lanjut',
                ]),
            ],
            'join_date' => ['nullable', 'date'],
        ];
    }
}
