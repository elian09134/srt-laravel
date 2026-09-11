<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFptkFulfilledRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $fptk = $this->route('fptk');
        $max = $fptk ? $fptk->qty : 1000;

        return [
            'fulfilled_count' => ['required', 'integer', 'min:0', "max:{$max}"],
        ];
    }
}
