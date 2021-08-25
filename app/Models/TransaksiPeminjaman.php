<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiPeminjaman extends Model
{
    protected $table = 'transaksi_peminjaman';

    public function peminjam()
    {
        return $this->belongsTo('App\Peminjam','kode_peminjam');
    }

    public function buku()
    {
        return $this->belongsTo('App\Models\Buku','kode_buku');
    }
}
