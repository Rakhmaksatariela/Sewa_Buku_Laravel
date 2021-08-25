@extends('layout.master')

@section('content')
    <div class="container">
        <h4>Detail Buku yang Dipinjam oleh Peminjam</h4>
        <h4>Kode Peminjam : {{ $peminjam->kode_peminjam }}</h4>
        <h4>Nama Peminjam : {{ $peminjam->nama_peminjam }}</h4>
        <table class="table table-striped">
            <thead>
                <th>Judul Buku</th>
            </thead>
            @foreach ($peminjam->buku as $item)
            <tbody>
                <tr>
                    <td>{{ $item->judul_buku}}</td>
                </tr>
            </tbody>
            @endforeach
        </table>
    </div>
@endsection
<!-- <td><a href="{{ route('peminjaman.detail_foto',$peminjam->peminjam['id']) }}">
                                {{ $transaksi_peminjaman->peminjam['nama_peminjam'] }}</a></td> -->

