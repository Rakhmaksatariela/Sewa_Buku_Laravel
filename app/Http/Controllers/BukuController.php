<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;

class BukuController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function index()
    {
        $jumlah_buku = Buku::count();
        $data_buku = Buku::orderBy('id', 'asc')->paginate(5);
        $no = 0;
        return view('buku.index', compact('data_buku','no','jumlah_buku'));

    }

    protected function create()
    {
        $list_buku = Buku::pluck('judul_buku', 'id');
        return view('buku.create', compact('list_buku'));
    }

    public function store(Request $request)
    {
        $buku = new Buku;
        $buku->kode_buku = $request->kode_buku;
        $buku->judul_buku = $request->judul_buku;
        $buku->jmlh_halaman = $request->jmlh_halaman;
        $buku->ISBN = $request->ISBN;
        $buku->pengarang = $request->pengarang;
        $buku->tahun_terbit = $request->tahun_terbit;
        $buku->save();

        return redirect('buku');
    }

    public function edit($id)
    {
        $buku = Buku::find($id);
        return view('buku.edit', compact('buku'));
    }

    public function update(Request $request, $id)
    {
        $buku = Buku::find($id);
        $buku->kode_buku = $request->kode_buku;
        $buku->judul_buku = $request->judul_buku;
        $buku->jmlh_halaman = $request->jmlh_halaman;
        $buku->ISBN = $request->ISBN;
        $buku->pengarang = $request->pengarang;
        $buku->tahun_terbit = $request->tahun_terbit;
        $buku->update();

        return redirect('buku');
    }

    public function destroy($id)
    {
        $buku = Buku::find($id);
        $buku->delete();

        return redirect('buku');
    }
}


// $this->validate($request, [
//     'name' => ['required', ' string', 'max:255'],
//     'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
//     'password' => ['required', 'string', 'min:8', 'confirmed'],
// ]);