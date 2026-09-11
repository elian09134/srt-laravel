<?php

namespace App\Http\Requests\Fptk;

use App\Support\Security;
use Illuminate\Foundation\Http\FormRequest;

class StoreFptkRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->user();
        return $user && $user->role === 'operasional';
    }

    protected function prepareForValidation(): void
    {
        $sanitized = [
            'position' => Security::cleanInput($this->position),
            'locations' => Security::cleanInput($this->locations),
            'division' => Security::cleanInput($this->division),
            'status_type' => Security::cleanInput($this->status_type),
            'golongan_gaji' => Security::cleanInput($this->golongan_gaji),
            'penempatan' => Security::cleanInput($this->penempatan),
            'usia' => Security::cleanInput($this->usia),
            'pendidikan' => Security::cleanInput($this->pendidikan),
            'keterampilan' => Security::cleanInput($this->keterampilan),
            'pengalaman' => Security::cleanInput($this->pengalaman),
            'uraian' => Security::cleanInput($this->uraian),
            'notes' => Security::cleanInput($this->notes),
            'signer_name' => Security::cleanInput($this->signer_name),
        ];

        if ($this->has('dasar_permintaan') && is_array($this->dasar_permintaan)) {
            $cleaned = [];
            foreach ($this->dasar_permintaan as $item) {
                if (is_string($item)) {
                    $cleaned[] = Security::cleanInput($item);
                }
            }
            $sanitized['dasar_permintaan'] = $cleaned;
        }

        $this->merge(array_filter($sanitized, fn($v) => ! is_null($v)));
    }

    public function rules(): array
    {
        return [
            'position' => ['required', 'string', 'max:255'],
            'locations' => ['nullable', 'string', 'max:255'],
            'qty' => ['nullable', 'integer', 'min:0'],
            'qty_female' => ['nullable', 'integer', 'min:0'],
            'division' => ['nullable', 'string', 'max:255'],
            'dasar_permintaan' => ['nullable', 'array'],
            'dasar_permintaan.*' => ['string', 'max:1000'],
            'date_needed' => ['nullable', 'date'],
            'status_type' => ['nullable', 'string', 'max:100'],
            'golongan_gaji' => ['nullable', 'string', 'max:255'],
            'penempatan' => ['nullable', 'string', 'max:255'],
            'gaji' => ['nullable', 'numeric'],
            'usia' => ['nullable', 'string', 'max:255'],
            'pendidikan' => ['nullable', 'string', 'max:255'],
            'keterampilan' => ['nullable', 'string', 'max:2000'],
            'pengalaman' => ['nullable', 'string', 'max:2000'],
            'uraian' => ['nullable', 'string', 'max:4000'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'signature' => ['required', 'string'],
            'signer_name' => ['required', 'string', 'max:255'],
        ];
    }
}
