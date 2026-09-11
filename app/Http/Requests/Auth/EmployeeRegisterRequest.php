<?php

namespace App\Http\Requests\Auth;

use App\Support\Security;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class EmployeeRegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $sanitized = [
            'phone_number' => Security::cleanInput($this->phone_number),
            'place_of_birth' => Security::cleanInput($this->place_of_birth),
            'current_address' => Security::cleanInput($this->current_address),
            'id_card_address' => Security::cleanInput($this->id_card_address),
            'religion' => Security::cleanInput($this->religion),
            'id_card_number' => Security::cleanInput($this->id_card_number),
            'father_name' => Security::cleanInput($this->father_name),
            'mother_name' => Security::cleanInput($this->mother_name),
            'department' => Security::cleanInput($this->department),
            'location' => Security::cleanInput($this->location),
            'position' => Security::cleanInput($this->position),
            'bank_name' => Security::cleanInput($this->bank_name),
            'account_number' => Security::cleanInput($this->account_number),
            'account_holder_name' => Security::cleanInput($this->account_holder_name),
            'emergency_contact_name' => Security::cleanInput($this->emergency_contact_name),
            'emergency_contact_phone' => Security::cleanInput($this->emergency_contact_phone),
            'emergency_contact_relation' => Security::cleanInput($this->emergency_contact_relation),
        ];

        $this->merge(array_filter($sanitized, fn($v) => ! is_null($v)));
    }

    public function rules(): array
    {
        return [
            'invitation_code' => ['required', 'string', 'exists:employee_invitations,invitation_code'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'phone_number' => ['required', 'string', 'max:20'],
            'place_of_birth' => ['required', 'string', 'max:255'],
            'date_of_birth' => ['required', 'date'],
            'current_address' => ['required', 'string'],
            'id_card_address' => ['required', 'string'],
            'gender' => ['required', 'string', Rule::in(['Pria', 'Wanita'])],
            'religion' => ['required', 'string'],
            'marital_status' => ['required', 'string'],
            'ptkp_status' => ['required', 'string'],
            'id_card_number' => ['required', 'string', 'max:255', 'unique:employees,id_card_number'],
            'father_name' => ['required', 'string'],
            'mother_name' => ['required', 'string'],
            'department' => ['required', 'string'],
            'location' => ['required', 'string'],
            'position' => ['required', 'string'],
            'join_date' => ['required', 'date'],
            'employment_status' => ['required', 'string'],
            'bank_name' => ['required', 'string'],
            'account_number' => ['required', 'string'],
            'account_holder_name' => ['required', 'string'],
            'emergency_contact_name' => ['required', 'string'],
            'emergency_contact_phone' => ['required', 'string'],
            'emergency_contact_relation' => ['required', 'string'],
        ];
    }
}
