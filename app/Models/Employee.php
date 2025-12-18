<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employee extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'employee_id',
        'position',
        'department',
        'location',
        'join_date',
        'employment_status',
        'place_of_birth',
        'date_of_birth',
        'gender',
        'religion',
        'marital_status',
        'ptkp_status',
        'id_card_number',
        'current_address',
        'id_card_address',
        'npwp_number',
        'family_card_number',
        'father_name',
        'mother_name',
        'spouse_name',
        'direct_supervisor_name',
        'direct_supervisor_position',
        'bank_name',
        'account_number',
        'account_holder_name',
        'emergency_contact_name',
        'emergency_contact_phone',
        'emergency_contact_relation',
    ];

    /**
     * Get the user that owns the employee profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected $casts = [
        'join_date' => 'date',
        'date_of_birth' => 'date',
    ];
}
