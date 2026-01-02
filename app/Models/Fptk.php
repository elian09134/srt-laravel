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
        'qty_male',
        'qty_female',
        'division',
        'dasar_permintaan',
        'date_needed',
        'status_type',
        'golongan_gaji',
        'penempatan',
        'gaji',
        'usia',
        'pendidikan',
        'keterampilan',
        'pengalaman',
        'uraian',
        'notes',
        'status',
        'admin_id',
        'admin_note',
    ];

    protected $casts = [
        'notes' => 'array',
        'date_needed' => 'date',
        'gaji' => 'integer',
        'qty_male' => 'integer',
        'qty_female' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    // decode notes JSON if stored as JSON
    public function getNotesDecodedAttribute()
    {
        $notes = $this->notes;
        if (! $notes) return null;
        return is_array($notes) ? $notes : $notes;
    }

    /**
     * Return keterampilan as array of trimmed items.
     */
    public function getKeterampilanListAttribute()
    {
        $k = $this->attributes['keterampilan'] ?? null;
        if (! $k) return [];
        if (is_array($k)) return $k;
        $items = array_filter(array_map('trim', explode(',', (string) $k)));
        return array_values($items);
    }

    /**
     * Return dasar_permintaan decoded as array when possible.
     */
    public function getDasarPermintaanListAttribute()
    {
        $d = $this->attributes['dasar_permintaan'] ?? null;
        if (! $d) return [];
        // if stored as JSON array string
        if (is_string($d) && in_array(substr($d,0,1), ['[','{'])){
            $decoded = json_decode($d, true);
            if (is_array($decoded)) return array_values($decoded);
        }
        // otherwise if comma-separated
        $items = array_filter(array_map('trim', preg_split('/[,;\n]+/', (string) $d)));
        return array_values($items);
    }

    /**
     * Normalize keterampilan when set: accept array or comma/string and store as comma-separated string.
     */
    public function setKeterampilanAttribute($value)
    {
        if (is_array($value)){
            $items = array_filter(array_map('trim', $value));
            $this->attributes['keterampilan'] = implode(', ', $items);
            return;
        }
        $str = (string) $value;
        // replace newlines with comma and normalize commas
        $normalized = preg_replace('/\s*\r?\n\s*/', ', ', $str);
        $normalized = preg_replace('/,+\s*/', ', ', $normalized);
        $this->attributes['keterampilan'] = trim($normalized, ", ");
    }
}
