<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Data_aset;
use Illuminate\Support\Facades\Auth;

class PeminjamanAdminController extends Controller
{
    public function peminjaman_admin()
    {
        // Ambil semua data peminjaman
        $peminjaman = Peminjaman::with(['user', 'data_aset'])->get();

        // Tampilkan data pada blade peminjaman-admin
        return view('peminjaman-admin', compact('peminjaman'));
    }

    public function update(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $validated = $request->validate([
            'status_peminjaman' => 'required|in:diterima,ditolak,pending',
        ]);

        $peminjaman->update($validated);

        return redirect()->back()->with('success', 'Status peminjaman berhasil diubah');
    }

    public function destroy($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->delete();

        return redirect()->back()->with('success', 'Peminjaman berhasil dihapus');
    }
}