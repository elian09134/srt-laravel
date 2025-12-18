<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TalentPool extends Model
{
    use HasFactory;

    protected $table = 'talent_pool'; // <--- Tambahkan baris ini
    protected $fillable = [
        'user_id',
        'status',
        'job_preferences',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}