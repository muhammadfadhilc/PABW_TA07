<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LaporanFasilitas extends Model
{
    protected $table = 'laporan_v2';

    protected $fillable = [
        'id_warga', 'tipe_fasilitas', 'lokasi', 'deskripsi',
        'status', 'tanggal_lapor', 'id_kontraktor',
    ];

    protected $casts = ['tanggal_lapor' => 'datetime'];

    public function warga(): BelongsTo
    {
        return $this->belongsTo(Warga::class, 'id_warga');
    }

    public function kontraktor(): BelongsTo
    {
        return $this->belongsTo(AdminPetugas::class, 'id_kontraktor');
    }
}
