<?php
 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierModel extends Model
{
    use HasFactory;

    protected $table = 'm_supplier'; // Sesuaikan dengan nama tabel di database
    protected $primaryKey = 'supplier_id';
    public $timestamps = false; // Jika tabel tidak memiliki `created_at` dan `updated_at`
 
    protected $fillable = ['supplier_kode', 'supplier_nama', 'alamat_supplier'];
} 