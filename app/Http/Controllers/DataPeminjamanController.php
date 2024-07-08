<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Peminjaman;
use App\Models\Data_aset;

class DataPeminjamanController extends Controller
{
    public function data_peminjaman()
    {
        $peminjaman = Peminjaman::with(['user', 'data_aset'])->get();
        $user = Auth::user();
        
        // Ambil hanya data aset yang memiliki status "tersedia"
        $data_asets = Data_aset::with('kategori')
            ->where('status', 'tersedia')
            ->get();

        return view('data_peminjaman', compact('peminjaman', 'user', 'data_asets'));
    }

    public function store(Request $request)
    {
        // Validasi data yang dikirimkan
        $validated = $request->validate([
            'data_aset_id' => 'required|exists:data_asets,id',
            'tgl_pinjam' => 'required|date',
            'tgl_kembali' => 'required|date|after_or_equal:tgl_pinjam',
            'status_peminjaman' => 'required|in:diterima,ditolak,pending',
        ]);

        // Ambil kategori_id dari Data_aset yang terkait dengan data_aset_id
        $data_aset = Data_aset::findOrFail($validated['data_aset_id']);
        $kategori_id = $data_aset->kategori_id;

        // Simpan data peminjaman dengan user_id dari pengguna yang login
        $validated['user_id'] = Auth::id();
        $validated['kategori_id'] = $kategori_id; // Simpan kategori_id ke dalam peminjaman
        Peminjaman::create($validated);

        // Redirect atau respon lainnya
        return redirect()->back()->with('success', 'Peminjaman berhasil ditambahkan');
    }
}
