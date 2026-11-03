<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Warga extends Model
{
    protected $table = 'warga_v2';

    protected $fillable = ['nama', 'username', 'password'];

    protected $hidden = ['password'];

    public function laporan(): HasMany
    {
        return $this->hasMany(LaporanFasilitas::class, 'id_warga');
    }
}
