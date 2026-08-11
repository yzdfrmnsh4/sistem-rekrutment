<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Lowongan extends Model
{
    use HasFactory;

    protected $table = 'lowongan';

    protected $fillable = [
        'judul_posisi',
        'slug',
        'departemen',
        'deskripsi',
        'kualifikasi',
        'kuota',
        'status',
        'tanggal_buka',
        'tanggal_tutup',
    ];

    protected $casts = [
        'tanggal_buka' => 'date',
        'tanggal_tutup' => 'date',
        'kuota' => 'integer',
    ];

    /**
     * Auto generate slug on save
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($lowongan) {
            if (empty($lowongan->slug)) {
                $lowongan->slug = Str::slug($lowongan->judul_posisi) . '-' . Str::random(5);
            }
        });
    }

    /**
     * Relationships
     */
    public function lamaran(): HasMany
    {
        return $this->hasMany(Lamaran::class, 'lowongan_id');
    }
}
