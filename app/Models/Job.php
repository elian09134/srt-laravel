<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'location',
        'type',
        'salary_range',
        'jobdesk',
        'requirement',
        'benefits',
        'is_active',
        'employment_type',
        'division',
        'closing_date',
        'fptk_id',
    ];

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function fptk()
    {
        return $this->belongsTo(Fptk::class);
    }
}
