<?php

namespace App\Models; // Pastikan namespace ini benar

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LevelModel extends Model
{
    use HasFactory;

    protected $table = 'm_level'; // Pastikan tabel benar
    protected $primaryKey = 'level_id';
    public $timestamps = false; 

    protected $fillable = ['level_id', 'level_kode', 'level_name'];
}