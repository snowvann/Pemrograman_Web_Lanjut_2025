<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'm_kategori'; // Pastikan tabel sudah sesuai
    protected $primaryKey = 'id'; // Pastikan ini sesuai dengan database
    public $timestamps = false; // Jika tidak menggunakan timestamp, maka set ke false

    protected $fillable = [
        'kategori_kode',
        'kategori_nama',
        'kategori_slug',
    ];
}
