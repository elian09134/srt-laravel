<?php

namespace App\Http\Requests\Admin;

use App\Support\Security;
use Illuminate\Foundation\Http\FormRequest;

class ApproveFptkRequest extends FormRequest
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
            'admin_signature' => ['required', 'string', function ($attribute, $value, $fail) {
                if (! preg_match('/^data:image\/(png|jpeg|webp|gif);base64,/', $value)) {
                    $fail('Tanda tangan tidak valid — format data URL gambar tidak dikenali.');
                    return;
                }

                $base64 = preg_replace('/^data:image\/(png|jpeg|webp|gif);base64,/', '', $value);
                $decoded = base64_decode($base64, true);

                if ($decoded === false) {
                    $fail('Tanda tangan tidak valid — data base64 corrupt.');
                    return;
                }

                $size = strlen($decoded);
                if ($size < 200) {
                    $fail('Tanda tangan tidak valid — ukuran terlalu kecil, kemungkinan tandatangan kosong.');
                    return;
                }

                if ($size > 512000) {
                    $fail('Tanda tangan terlalu besar — maksimal 500KB.');
                    return;
                }
            }],
        ];
    }
}
