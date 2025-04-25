<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailPenjualanModel extends Model
{
    protected $table = 't_penjualan_detail'; // Nama tabel sesuai dengan seeder dan konvensi
    protected $primaryKey = 'id'; // Jika ada kolom 'id' sebagai primary key, jika tidak, sesuaikan
    public $timestamps = true; // Karena seeder menyertakan created_at dan updated_at
    protected $fillable = [
        'penjualan_id',
        'barang_id',
        'harga',
        'jumlah',
        // tambahkan kolom lain yang bisa diisi
    ];

    // Relasi dengan model Penjualan
    public function penjualan(): BelongsTo
    {
        return $this->belongsTo(PenjualanModel::class, 'penjualan_id');
    }

    // Relasi dengan model Barang
    public function barang(): BelongsTo
    {
        return $this->belongsTo(BarangModel::class, 'barang_id');
    }
}
