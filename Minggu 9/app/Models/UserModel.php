<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable; // implementasi class
use Tymon\JWTAuth\Contracts\JWTSubject;

class UserModel extends Authenticatable implements JWTSubject
{
    use HasFactory;

    public function getJWTIdentifier(){
        return $this->getKey();
    }

    public function getJWTCustomClaims(){
        return[];
    }

    protected $table = 'm_user'; //mendefinisikan nama tabel yang digunakan model
    protected $primaryKey = 'user_id'; //mendefinisikan primary key dari tabel

    protected $fillable = ['level_id', 'username', 'nama', 'password', 'created_at', 'updated_at', 'foto_profile']; //mendefinisikan kolom yang akan diisi oleh user

    protected $hidden = ['password']; // jangan di tampilkan saat select

    protected $casts = ['password' => 'hashed']; // casting password agar otomatis dihashing


    // relasi ke tabel level
    public function level(): BelongsTo
    {
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }

    //mendapat nama role
    public function getRoleName(): string
    {
        return $this->level->level_name;
    }

    // cek apakah user memiliki role tertentu
    public function hasRole($role) : bool
    {
        return $this->level->level_kode == $role;
    }

    //mendapat kode role`
    public function getRole()
    {
        return $this->level->level_kode;
    }
}
