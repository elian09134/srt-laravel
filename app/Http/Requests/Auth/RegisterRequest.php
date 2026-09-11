<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use App\Rules\SecureFileUploadRule;
use App\Support\Security;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $sanitized = [
            'name' => Security::cleanInput($this->name),
            'nickname' => Security::cleanInput($this->nickname),
            'phone_number' => Security::cleanInput($this->phone_number),
            'about_me' => Security::cleanInput($this->about_me),
            'institution' => Security::cleanInput($this->institution),
            'major' => Security::cleanInput($this->major),
            'referral_source' => Security::cleanInput($this->referral_source),
            'skills' => Security::cleanInput($this->skills),
            'languages' => Security::cleanInput($this->languages),
            'job_interest' => Security::cleanInput($this->job_interest),
            'last_company' => Security::cleanInput($this->last_company),
            'last_position' => Security::cleanInput($this->last_position),
            'last_company_duration' => Security::cleanInput($this->last_company_duration),
        ];

        if ($this->has('experience') && is_array($this->experience)) {
            $cleanedExp = [];
            foreach ($this->experience as $key => $exp) {
                if (is_array($exp)) {
                    $cleanedExp[$key] = [
                        'company' => isset($exp['company']) ? Security::cleanInput($exp['company']) : null,
                        'position' => isset($exp['position']) ? Security::cleanInput($exp['position']) : null,
                        'duration' => isset($exp['duration']) ? Security::cleanInput($exp['duration']) : null,
                        'jobdesk' => isset($exp['jobdesk']) ? Security::cleanInput($exp['jobdesk']) : null,
                    ];
                }
            }
            $sanitized['experience'] = $cleanedExp;
        }

        $this->merge(array_filter($sanitized, fn($val) => ! is_null($val)));
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'nickname' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:20'],
            'date_of_birth' => ['required', 'date'],
            'about_me' => ['required', 'string'],
            'education_level' => [
                'required',
                'string',
                Rule::in(['SMA', 'SMK', 'SMA/SMK', 'SMK/Sederajat', 'SMA/Sederajat', 'D1', 'D2', 'D3', 'D4', 'S1', 'S2', 'S3']),
            ],
            'institution' => ['required', 'string', 'max:255'],
            'major' => ['required', 'string', 'max:255'],
            'referral_source' => ['required', 'string', 'max:255'],
            'cv' => ['required', 'file', new SecureFileUploadRule(['pdf'])],
            'photo' => ['nullable', 'file', new SecureFileUploadRule(['jpg', 'jpeg', 'png'])],
            'formal_photo' => ['required', 'file', new SecureFileUploadRule(['jpg', 'jpeg', 'png'])],
            'ktp' => ['required', 'file', new SecureFileUploadRule(['jpg', 'jpeg', 'png'])],
            'kk' => ['required', 'file', new SecureFileUploadRule(['jpg', 'jpeg', 'png'])],
            'npwp' => ['nullable', 'file', new SecureFileUploadRule(['jpg', 'jpeg', 'png'])],
            'ijazah' => ['required', 'file', new SecureFileUploadRule(['pdf', 'jpg', 'jpeg', 'png'])],
            'certificate' => ['nullable', 'file', new SecureFileUploadRule(['pdf', 'jpg', 'jpeg', 'png'])],
            'experience' => ['nullable', 'array'],
            'experience.*.company' => ['nullable', 'string', 'max:255'],
            'experience.*.position' => ['nullable', 'string', 'max:255'],
            'experience.*.duration' => ['nullable', 'string', 'max:255'],
            'experience.*.jobdesk' => ['nullable', 'string'],
            'currently_employed' => ['nullable', 'boolean'],
            'expected_salary' => ['required', 'numeric', 'min:0'],
            'skills' => ['nullable', 'string'],
            'languages' => ['nullable', 'string'],
            'job_interest' => ['nullable', 'string', 'max:255'],
            'last_company' => ['nullable', 'string', 'max:255'],
            'last_position' => ['nullable', 'string', 'max:255'],
            'last_company_duration' => ['nullable', 'string', 'max:255'],
        ];
    }
}
