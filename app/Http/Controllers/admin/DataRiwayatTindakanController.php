<?php

namespace App\Http\Controllers\admin;

use App\Models\Barang;
use App\Models\Merk;
use App\Models\Komplain;
use App\Models\Histori;
use App\Models\Petugas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DataRiwayatTindakanController extends Controller
{
    
    
    public function index()
    {
        $historis = Histori::all();
        $petugasList = Petugas::pluck('nama', 'id');
        return view('pages.admin.DataRiwayatTindakan.index', [
            'complains' => Komplain::all(),
            'barangs' => Barang::all(),
            'merks' => Merk::all(),
            'petugasList' => $petugasList,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tindakan' => ['required', 'string'],
            'tanggal_pembelian' => ['required', 'date'],
            'tanggal_selesai' => ['required', 'date'],
            'id_petugas' => ['required', 'exists:petugas,id'],
            'id_komplain' => ['required', 'exists:komplain,id'],
        ]);

        if(!$validated){
            return redirect()->route('pages.admin.dataRiwayatTindakan.index')->with('error', 'validated failed!');
        }

        Histori::create($validated);

        return redirect()->route('pages.admin.dataRiwayatTindakan.index')->with('success', 'validated succes!');

    }
}
