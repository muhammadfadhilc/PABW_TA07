<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AdminPetugas extends Model
{
    protected $table = 'admins_v2';

    protected $fillable = ['nama', 'username', 'password', 'role'];

    protected $hidden = ['password'];

    public function penugasan(): HasMany
    {
        return $this->hasMany(LaporanFasilitas::class, 'id_kontraktor');
    }
}
