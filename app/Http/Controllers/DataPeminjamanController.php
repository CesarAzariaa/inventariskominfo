<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Data_aset;
use App\Models\Peminjaman;
use App\Models\Kategori;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DataPeminjamanController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $data_asets = Data_aset::with('kategori')->where('status', 'Tersedia')->get();
        $grouped_data_asets = $data_asets->groupBy('nama_aset');

        return view('data_peminjaman', compact('user', 'grouped_data_asets'));
    }

    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'nama' => 'required|string|max:255',
            'asal_instansi' => 'required|string|max:255',
            'no_handphone' => 'required|string|max:15',
            'nama_aset' => 'required|string|max:255',
            'merk' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'stok' => 'required|integer',
            'tgl_pinjam' => 'required|date',
            'tgl_kembali' => 'required|date',
            'status_peminjaman' => 'required|string|max:255',
            'data_aset_id' => 'required|integer',
        ]);

        // Kurangi stok dari aset yang dipilih
        $aset = Data_aset::findOrFail($request->data_aset_id);

        // Pastikan stok cukup untuk dipinjam
        if ($aset->stok < $request->stok) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi untuk peminjaman.');
        }

        // Kurangi stok pada data aset yang lama
        $aset->stok -= $request->stok;
        $aset->save();

        // Buat duplikasi data aset dengan stok yang dikurangi dan status 'Dipinjam'
        $newAset = $aset->replicate();
        $newAset->stok = $request->stok;
        $newAset->status = 'Dipinjam';
        $newAset->save();

        // Simpan data ke tabel peminjamans
        Peminjaman::create([
            'user_id' => auth()->user()->id,
            'data_aset_id' => $request->data_aset_id,
            'tgl_pinjam' => $request->tgl_pinjam,
            'tgl_kembali' => $request->tgl_kembali,
            'status_peminjaman' => $request->status_peminjaman,
        ]);

        return redirect()->route('data_peminjaman.index')->with('success', 'Data peminjaman berhasil disimpan.');
    }

    public function showHistoryPeminjaman()
    {
        $riwayat_peminjaman = Peminjaman::where('user_id', auth()->id())->with('data_aset')->get();
        return view('history-peminjaman', compact('riwayat_peminjaman'));
    }
}