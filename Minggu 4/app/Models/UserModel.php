<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    use HasFactory;

    protected $table = 'm_user'; // Mendefinisikan nama tabel yang digunakan
    protected $primaryKey = 'user_id'; // Mendefinisikan primary key dari tabel yang digunakan
    /**
     * The attributes that are assignable
     * 
     * @var array
     */
    protected $fillable = ['level_id', 'username', 'nama', 'password'];
}