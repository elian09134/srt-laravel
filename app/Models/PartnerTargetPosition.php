<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PartnerTargetPosition extends Model
{
    protected $fillable = [
        'partner_target_id',
        'position',
        'target_count',
    ];

    public function partnerTarget(): BelongsTo
    {
        return $this->belongsTo(PartnerTarget::class);
    }
}
