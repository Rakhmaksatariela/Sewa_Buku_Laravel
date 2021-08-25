<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $table = 'buku';
    protected $fillable = ['judul_buku','jml_halaman','pengarang','tahun_terbit'];

    public function peminjam()
    {
        return $this->belongsToMany('App\Peminjam','transaksi_peminjaman','kode_buku','kode_peminjam');
    }

    public function transaksi_peminjaman()
    {
        return $this->hasMany('App\Models\TransaksiPeminjaman','kode_buku');
    }
}
