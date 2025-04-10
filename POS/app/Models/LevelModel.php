<?php

namespace App\Models; // Pastikan namespace ini benar
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LevelModel extends Model
{
    protected $table = 'm_level'; // pastikan nama tabel sesuai di database

    protected $primaryKey = 'level_id';

    public $timestamps = false; // jika tidak ada kolom created_at dan updated_at

    protected $fillable = ['level_id', 'level_name'];
}
