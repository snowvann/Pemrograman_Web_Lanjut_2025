<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PenjualanModel extends Model
{
    protected $table = 't_penjualan'; // Nama tabel sesuai dengan migrasi
    protected $primaryKey = 'penjualan_id'; // Primary key sesuai dengan migrasi
    protected $fillable = [
        'user_id',
        'pembeli',
        'penjualan_kode',
        'penjualan_tanggal',
        // tambahkan kolom lain yang bisa diisi secara massal
    ];

    protected $casts = [
        'penjualan_tanggal' => 'datetime', // Cast ke tipe datetime
    ];

    // Relasi dengan model User
    public function user(): BelongsTo
    {
        return $this->belongsTo(UserModel::class, 'user_id');
    }

    // Relasi dengan model DetailPenjualan (jika ada)
    public function detailPenjualan(): HasMany
    {
        return $this->hasMany(DetailPenjualanModel::class, 'penjualan_id');
    }
}
