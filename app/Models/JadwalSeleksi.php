<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JadwalSeleksi extends Model
{
    use HasFactory;

    protected $table = 'jadwal_seleksi';

    protected $fillable = [
        'lamaran_id',
        'tahap_seleksi',
        'tanggal_waktu',
        'lokasi_atau_link',
        'instruksi_tambahan',
    ];

    protected $casts = [
        'tanggal_waktu' => 'datetime',
    ];

    /**
     * Relationships
     */
    public function lamaran(): BelongsTo
    {
        return $this->belongsTo(Lamaran::class, 'lamaran_id');
    }
}
