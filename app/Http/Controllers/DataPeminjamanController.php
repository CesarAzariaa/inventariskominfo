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


        $data_asets = Data_aset::with('kategori')->get();
        $grouped_data_asets = $data_asets->groupBy('nama_aset');

        return view('data_peminjaman', compact('user', 'grouped_data_asets'));
    }

    public function store(Request $request)
{
    // Validasi request
    $request->validate([
        'nama_aset' => 'required',
        'tgl_pinjam' => 'required|date',
        'tgl_kembali' => 'required|date|after:tgl_pinjam',
        'status_peminjaman' => 'required|in:pending,diterima,ditolak',
        'stok' => 'required|integer|min:1', // validasi stok yang dipilih
    ]);

    $user = Auth::user();

    // Mulai transaksi database
    DB::beginTransaction();

    try {
        // Simpan data peminjaman
        $peminjaman = Peminjaman::create([
            'user_id' => $user->id,
            'data_aset_id' => $request->data_aset_id,
            'tgl_pinjam' => $request->tgl_pinjam,
            'tgl_kembali' => $request->tgl_kembali,
            'status_peminjaman' => $request->status_peminjaman,
        ]);

        // Kurangi stok dari aset yang dipilih
        $aset = Data_aset::findOrFail($request->data_aset_id);
        $aset->stok -= $request->stok;
        $aset->save();

        // Commit transaksi jika sukses
        DB::commit();

        return redirect()->route('data_peminjaman.index')->with('success', 'Peminjaman berhasil dibuat.');
    } catch (\Exception $e) {
        // Rollback transaksi jika terjadi kesalahan
        DB::rollback();

        return redirect()->back()->with('error', 'Gagal membuat peminjaman: ' . $e->getMessage());
    }
}
}
