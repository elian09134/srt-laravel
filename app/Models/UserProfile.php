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
        'skills',
        'languages',
        'job_interest',
        'cv_path',
        'photo_path',
    ];
}
