<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisPeminjam extends Model
{
    protected $table = 'jenis_peminjam';
    protected $fillable = ['nama_jenis_peminjam'];
    
    public function peminjam()
    {
        return $this->hasMany('App\Peminjam','id_jenis_peminjam');
    }
}
