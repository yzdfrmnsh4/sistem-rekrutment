<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lamaran extends Model
{
    use HasFactory;

    protected $table = 'lamaran';

    protected $fillable = [
        'kode_pendaftaran',
        'user_id',
        'lowongan_id',
        'path_cv',
        'path_ijazah',
        'path_ktp',
        'path_pendukung',
        'status_lamaran',
        'catatan_admin',
    ];

    /**
     * Relationships
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function lowongan(): BelongsTo
    {
        return $this->belongsTo(Lowongan::class, 'lowongan_id');
    }

    public function jadwalSeleksi(): HasMany
    {
        return $this->hasMany(JadwalSeleksi::class, 'lamaran_id');
    }

    public function hasilSeleksi(): HasOne
    {
        return $this->hasOne(HasilSeleksi::class, 'lamaran_id');
    }
}
