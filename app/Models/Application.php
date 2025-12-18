<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
      'user_id',
      'job_id',
      'status',
      'cover_letter',
      'applicant_name',
      'applicant_email',
      'applicant_phone',
      'applicant_last_position',
      'applicant_last_education',
    ];
  public function user()
{
    return $this->belongsTo(User::class);
}

public function job()
{
    return $this->belongsTo(Job::class);
}
    
  public function statusHistories()
  {
    return $this->hasMany(ApplicationStatusHistory::class)->orderBy('created_at', 'desc');
  }

  //
}
