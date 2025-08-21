<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeInvitation extends Model
{
    use HasFactory;

    protected $table = 'employee_invitations';

    protected $fillable = [
        'full_name',
        'phone_number',
        'invitation_code',
        'expires_at',
        'used_at',
    ];
}
