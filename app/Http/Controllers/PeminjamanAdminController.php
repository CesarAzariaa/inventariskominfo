<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class PeminjamanAdminController extends Controller
{
    public function peminjaman_admin(Request $request)
    {
        // Ambil semua data peminjaman beserta relasi user dan data_aset
        $peminjaman = Peminjaman::with(['user', 'data_aset'])->get();

        // Tampilkan data pada blade peminjaman-admin
        return view('peminjaman-admin', compact('peminjaman'));
    }

    public function terimaPeminjaman(Request $request)
    {
        $peminjamanId = $request->input('peminjaman_id');
        $peminjaman = Peminjaman::find($peminjamanId);

        if ($peminjaman) {
            // Update status peminjaman
            $peminjaman->status_peminjaman = 'diterima';
            $peminjaman->save();

            // Kirim pesan ke bot Telegram
            $telegramBotToken = '7398432259:AAHo1TbFn8td5P6Dm9SsaRSONwSe-IDyGB4';
            $chatId = $peminjaman->user->chat_id;
            $message = "Selamat peminjaman aset Anda telah diterima! Berikut detail aset Anda:\n" .
                       "Nama Aset   : {$peminjaman->data_aset->nama_aset}\n" .
                       "Merk    : {$peminjaman->data_aset->merk}\n" .
                       "Model   : {$peminjaman->data_aset->model}\n" .
                       "Tanggal Pinjam  : {$peminjaman->tgl_pinjam}\n" .
                       "Aset harus dikembalikan pada tanggal " . Carbon::parse($peminjaman->tgl_kembali)->format('d F Y') . " sesuai kebutuhan Anda. Terimakasih";

            $response = Http::post("https://api.telegram.org/bot{$telegramBotToken}/sendMessage", [
                'chat_id' => $chatId,
                'text' => $message,
            ]);

            if ($response->successful()) {
                return redirect()->back()->with('success', 'Peminjaman diterima dan pesan telah dikirim ke pengguna.');
            } else {
                return redirect()->back()->with('error', 'Peminjaman diterima tetapi gagal mengirim pesan ke pengguna.');
            }
        }

        return redirect()->back()->with('error', 'Peminjaman tidak ditemukan.');
    }

}