<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Data_aset;
use App\Models\Peminjaman;
use App\Models\Kategori;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\TelegramService;

class DataPeminjamanController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $data_asets = Data_aset::with('kategori')->get();
        $grouped_data_asets = $data_asets->groupBy('nama_aset');

        return view('data_peminjaman', compact('user', 'grouped_data_asets'));
    }

    public function store(Request $request, TelegramService $telegramService)
    {
        // Validasi request
        $request->validate([
            'nama_aset' => 'required',
            'tgl_pinjam' => 'required|date',
            'tgl_kembali' => 'required|date|after:tgl_pinjam',
            'status_peminjaman' => 'required|in:pending,diterima',
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

            // Kirim pesan Telegram setelah sukses membuat peminjaman
            $no_handphone = $user->chat_id; // Asumsikan kolom chat_id di tabel users menyimpan ID chat Telegram
            if ($no_handphone) {
                $message = "Hello, your asset borrowing has been recorded successfully. Please return it by {$request->tgl_kembali}.";
                $telegramService->sendMessage($no_handphone, $message);
            }

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
