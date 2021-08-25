<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Peminjam;
use App\Models\Telepon;
use App\Models\JenisPeminjam;
use App\Models\User;
use Session;
use Storage;

class PeminjamController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data_peminjam = Peminjam::orderBy('id', 'asc')->paginate(5);
        $jumlah_peminjam = Peminjam::count();
        $no = 0;
        return view('peminjams.index', compact('data_peminjam', 'no', 'jumlah_peminjam'));
    }

    // public function lihat_data_peminjam() {
    //     $peminjam = ['Tata', 'Rizki', 'Aulia', 'Irma'];
    //     return view('peminjams/lihat_data_peminjam', compact('peminjam')); 
    // }

    // public function index()versi lama
    // {
    //     $data_peminjam = Peminjam::all()->sortBy('nama_peminjam');
    //     $jumlah_peminjam = $data_peminjam->count();
    //     return view('peminjams.index', compact('data_peminjam', 'jumlah_peminjam'));
    // }

    public function create(){
        $user = User::find(\DB::table('users')->max('id'));
        $name = $user['name'];
        $id_user = $user['id'];
        $list_jenis_peminjam = JenisPeminjam::pluck('nama_jenis_peminjam','id_jenis_peminjam');
        return view('peminjams.create',compact('list_jenis_peminjam','id_user', 'name'));
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'kode_peminjam' => 'required|string',
            'nama_peminjam' => 'required|string|max:30',
            'tgl_lahir' => 'required|date',
            'alamat' => 'required|string'
        ]);
        
        $this->validate($request,[
            'foto_peminjam' => 'required|image|mimes:png,jpg,jpeg',
        ]);
        $foto_peminjam = $request->foto_peminjam;
        $nama_file = time().'.'.$foto_peminjam->getClientOriginalExtension(); 
        $foto_peminjam->move('foto_peminjam/', $nama_file); 

        $peminjam = new Peminjam;
        $peminjam->kode_peminjam = $request->kode_peminjam;
        $peminjam->nama_peminjam = $request->nama_peminjam;
        $peminjam->tgl_lahir = $request->tgl_lahir;
        $peminjam->alamat = $request->alamat;
        $peminjam->id_jenis_peminjam = $request->id_jenis_peminjam;
        $peminjam->foto_peminjam=$nama_file;
        $peminjam->id_user = $request->id_user;
        $peminjam->save();

        $telepon = new Telepon;
        $telepon->nomor_telepon = $request->telepon;
        $peminjam->telepon()->save($telepon);

        Session::flash('flash_message','Data peminjam berhasil disimpan');

        return redirect('peminjam');
    }

    public function edit($id)
    {
        $peminjam = Peminjam::find($id);
        if(!empty($peminjam->telepon->nomor_telepon))
        {
            $peminjam->nomor_telepon = $peminjam->telepon->nomor_telepon;
        }
        $list_jenis_peminjam = JenisPeminjam::pluck('nama_jenis_peminjam','id_jenis_peminjam');
        return view('peminjams.edit', compact('peminjam','list_jenis_peminjam'));
    }

    public function update(Request $request, $id)
    {
        $peminjam = Peminjam::find($id);
        if($request->has('foto_peminjam'))
        {
           $foto_peminjam = $request->foto_peminjam;
           $nama_file = time().'.'.$foto_peminjam->getClientOriginalExtension();
           $foto_peminjam->move('foto_peminjam/', $nama_file);
           $peminjam->kode_peminjam = $request->kode_peminjam;
           $peminjam->nama_peminjam = $request->nama_peminjam;
           $peminjam->tgl_lahir = $request->tgl_lahir;
           $peminjam->alamat = $request->alamat;
           $peminjam->id_jenis_peminjam = $request->id_jenis_peminjam;
           $peminjam->foto_peminjam = $nama_file;
           $peminjam->update();
        }
        else
        {
            $peminjam->kode_peminjam = $request->kode_peminjam;
            $peminjam->nama_peminjam = $request->nama_peminjam;
            $peminjam->tgl_lahir = $request->tgl_lahir;
            $peminjam->alamat = $request->alamat;
            $peminjam->id_jenis_peminjam = $request->id_jenis_peminjam;
            $peminjam->update();
        }

        //update jika sudah ada
        if($peminjam->telepon)
        {
            if($request->filled('nomor_telepon'))
            {
                $telepon = $peminjam->telepon;
                $telepon->nomor_telepon = $request->input('nomor_telepon');
                $peminjam->telepon()->save($telepon);
            }else
            {
                $peminjam->telepon()->delete();
            }
        }
        //buat entry baru jika belum ada
        else
        {
            if($request->filled('nomor_telepon'))
            {
                $telepon = new Telepon;
                $telepon->nomor_telepon = $request->nomor_telepon;
                $peminjam->telepon()->save($telepon);
            }
        }

        Session::flash('flash_message','Data peminjam berhasil disimpan');

        return redirect('peminjam')->with('pesan','Data peminjam berhasail di update');
    }

    public function destroy($id)
    {
        $peminjam = Peminjam::find($id);
        $peminjam->delete();

        Session::flash('flash_message2','Data peminjam 
        ;berhasil dihapus');
        Session::flash('penting', true);

        return redirect('peminjam');
    }

    public function search(Request $request)
    {
        $cari = $request->words;
        $data_peminjam = Peminjam::where('nama_peminjam','like', '%'.$cari.'%')->paginate(5);
        $no = 5 * ($data_peminjam->currentPage() - 1);
        return view('peminjams.search', compact('data_peminjam','no','cari'));
    }

    public function Coba_collection() {
        $daftar = ['Tata', 'Rizki', 'Izal', 'Irma'];
        $collection = collect($daftar)->map(function($nama){
            return ucwords($nama);
        });
        return $collection; 
    }

    public function collection_first()
    {
        $collection = peminjam::all()->first();
        return $collection;
    }

    public function collection_last()
    {
        $collection = peminjam::all()->last();
        return $collection;
    }

    public function collection_count()
    {
        $collection = peminjam::all();
        $jumlah = $collection->count();
        return 'Jumlah peminjam : ' .$jumlah;
    }

    public function collection_take()
    {
        $collection = peminjam::all()->take(3);
        return $collection;
    }

    public function collection_pluck()
    {
        $collection = peminjam::all()->pluck('nama_peminjam');
        return $collection;
    }

    public function collection_where()
    {
        $collection = peminjam::all()->where('kode_peminjam','P0004');
        return $collection;
    }

    public function collection_wherein()
    {
        $collection = peminjam::all()->whereIn('kode_peminjam', ['P0001', 'P0002', 'P0004']);
        return $collection;
    }

    public function collection_toarray()
    {
        $collection = peminjam::select('kode_peminjam', 'nama_peminjam')->take(3)->get();
        $koleksi = $collection->toArray();
        foreach($koleksi as $peminjam){
            echo $peminjam['kode_peminjam'].' - '.$peminjam['nama_peminjam'].'<br>';
        }
    }

    public function collection_tojson()
    {
        $data = [
            ['kode_peminjam'=> 'P0001', 'nama_peminjam' => 'Rakhma Aksata'],
            ['kode_peminjam'=> 'P0002', 'nama_peminjam' => 'Irmatul'],
            ['kode_peminjam'=> 'P0004', 'nama_peminjam' => 'M Izal']
        ];
        $collection = collect($data)->toJson();
        return $collection;
    }
}
