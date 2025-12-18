<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nickname',
        'phone_number',
        'date_of_birth',
        'about_me',
        'education_level',
        'institution',
        'major',
        'last_company',
        'last_position',
        'last_company_duration',
        'skills',
        'languages',
        'job_interest',
        'cv_path',
        'photo_path',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    /**
     * Get the formatted date of birth
     */
    public function getFormattedDateOfBirthAttribute()
    {
        if (!$this->date_of_birth) {
            return null;
        }

        // Handle both Carbon object and string
        $date = $this->date_of_birth;
        if (is_string($date)) {
            $date = \Carbon\Carbon::parse($date);
        }

        return $date->format('d M Y');
    }
}
