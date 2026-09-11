<?php

namespace App\Http\Requests\Admin;

use App\Rules\SecureFileUploadRule;
use App\Support\Security;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateJobRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'title' => Security::cleanInput($this->title),
            'location' => Security::cleanInput($this->location),
            'salary_range' => Security::cleanInput($this->salary_range),
            'jobdesk' => Security::cleanInput($this->jobdesk),
            'requirement' => Security::cleanInput($this->requirement),
            'benefits' => Security::cleanInput($this->benefits),
        ]);
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', Rule::in(['Full Time', 'Part Time', 'Contract', 'Internship'])],
            'salary_range' => ['nullable', 'string', 'max:100'],
            'jobdesk' => ['required', 'string'],
            'requirement' => ['required', 'string'],
            'benefits' => ['nullable', 'string'],
            'fptk_id' => ['nullable', 'exists:fptks,id'],
            'image' => ['nullable', 'file', new SecureFileUploadRule(['jpg', 'jpeg', 'png'])],
            'is_active' => ['nullable', 'boolean'],
            'show_image' => ['nullable', 'boolean'],
        ];
    }
}
