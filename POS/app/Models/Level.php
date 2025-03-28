<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    protected $table = 'm_level'; // Menyesuaikan dengan nama tabel

    protected $fillable = [
        'level_kode',
        'level_nama',
    ];

    /**
     * Relasi dengan tabel User
     */
    public function users()
    {
        return $this->hasMany(User::class, 'level_id', 'id');
    }
}
