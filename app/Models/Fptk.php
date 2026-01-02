<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Fptk extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'position',
        'locations',
        'qty',
        'notes',
        'status',
        'admin_id',
        'admin_note',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
