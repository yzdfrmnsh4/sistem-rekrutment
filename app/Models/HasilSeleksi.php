<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HasilSeleksi extends Model
{
    use HasFactory;

    protected $table = 'hasil_seleksi';

    protected $fillable = [
        'lamaran_id',
        'nilai_tes',
        'nilai_wawancara',
        'keputusan_akhir',
        'catatan_evaluasi',
        'tanggal_pengumuman',
    ];

    protected $casts = [
        'nilai_tes' => 'decimal:2',
        'nilai_wawancara' => 'decimal:2',
        'tanggal_pengumuman' => 'date',
    ];

    /**
     * Relationships
     */
    public function lamaran(): BelongsTo
    {
        return $this->belongsTo(Lamaran::class, 'lamaran_id');
    }
}
