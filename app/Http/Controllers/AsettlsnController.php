<?php

namespace App\Http\Controllers;

use Session;
use App\Models\Asettlsn;
use Illuminate\Http\Request;
use App\Exports\AsettlsnExport;
use Maatwebsite\Excel\Facades\Excel;

class AsettlsnController extends Controller
{
    public function index(Request $request)
    {
        $katakunci = $request->katakunci;
        $sortby = $request->sortby;
        $order = $request->order == 'desc' ? 'desc' : 'asc'; // Default ke ascending jika tidak ada order atau bukan 'desc'
        $jumlahbaris = 10;
        
        $query = Asettlsn::query();

        if ($katakunci) {
            $query->where('namabarang', 'like', "%$katakunci%")
                ->orWhere('tahun', 'like', "%$katakunci%")
                ->orWhere('jumlah', 'like', "%$katakunci%")
                ->orWhere('nomorinventaris', 'like', "%$katakunci%")
                ->orWhere('nomorseri', 'like', "%$katakunci%")
                ->orWhere('harga', 'like', "%$katakunci%")
                ->orWhere('lokasi', 'like', "%$katakunci%")
                ->orWhere('kondisi', 'like', "%$katakunci%");
        }

        if ($sortby) {
            $query->orderBy($sortby, $order);
        } else {
            $query->orderBy('namabarang', 'asc');
        }

        $data = $query->paginate($jumlahbaris);

        return view('aset.aset', [
            'data' => $data,
            'sortby' => $sortby,
            'order' => $order,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('aset.tambahaset');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Session::flash('id',$request->id);
        Session::flash('namabarang',$request->namabarang);
        Session::flash('tahun',$request->tahun);
        Session::flash('jumlah',$request->jumlah);
        Session::flash('nomorinventaris',$request->nomorinventaris);
        Session::flash('nomorseri',$request->nomorseri);
        Session::flash('harga',$request->harga);
        Session::flash('lokasi',$request->lokasi);
        Session::flash('kondisi',$request->kondisi);

        $request->validate([
            'namabarang'=>'required:asettlsn,namabarang'
        ],[
            'namabarang.required'=>'Nama Barang Wajib Diisi!'
        ]);
        $data = [
            'namabarang' => $request->namabarang,
            'tahun' => $request->tahun,
            'jumlah' => $request->jumlah,
            'nomorinventaris' => $request->nomorinventaris,
            'nomorseri' => $request->nomorseri,
            'harga' => $request->harga,
            'lokasi' => $request->lokasi,
            'kondisi' => $request->kondisi,
        ];
        Asettlsn::create($data);
        return redirect()->to('Asettlsn')->with('success','Data Berhasil Ditambahkan!');
    }
    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Asettlsn::where('id', $id)-> first();
        return view('aset.editaset')->with('data', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = [
            'tahun' => $request->tahun,
            'jumlah' => $request->jumlah,
            'nomorinventaris' => $request->nomorinventaris,
            'nomorseri' => $request->nomorseri,
            'harga' => $request->harga,
            'lokasi' => $request->lokasi,
            'kondisi' => $request->kondisi,
        ];
        Asettlsn::where('id',$id)->update($data);
        return redirect()->to('Asettlsn')->with('success','Data Berhasil Diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Asettlsn::where('id',$id)->delete();
        return redirect()->to('Asettlsn')->with('success','Data Berhasil Dihapus!');
    }

    public function asetexport() 
    {
        return Excel::download(new AsettlsnExport, 'Daftar_Aset_Yayasan_Satunama.xlsx');
    }
}
