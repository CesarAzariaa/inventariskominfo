<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;

class PeminjamanAdminController extends Controller
{
    public function peminjaman_admin(Request $request)
    {
        // Lakukan sesuatu dengan $request jika diperlukan

        // Ambil semua data peminjaman beserta relasi user dan data_asets
        $peminjaman = Peminjaman::with(['user', 'data_aset'])->get();

        // Tampilkan data pada blade peminjaman-admin
        return view('peminjaman-admin', compact('peminjaman'));
    }

    public function terimaPeminjaman(Request $request)
    {
        $peminjamanId = $request->input('peminjaman_id');
        $peminjaman = Peminjaman::find($peminjamanId);

        if ($peminjaman) {
            // Kirim pesan ke bot Telegram
            $telegramBotToken = env('TELEGRAM_BOT_TOKEN');
            $chatId = $peminjaman->user->chat_id;
            $message = "Peminjaman Anda telah diterima.";

            $response = Http::post("https://api.telegram.org/bot{$telegramBotToken}/sendMessage", [
                'chat_id' => $chatId,
                'text' => $message,
            ]);

            if ($response->successful()) {
                return redirect()->back()->with('success', 'Pesan telah dikirim ke pengguna.');
            } else {
                return redirect()->back()->with('error', 'Gagal mengirim pesan ke pengguna.');
            }
        }

        return redirect()->back()->with('error', 'Peminjaman tidak ditemukan.');
    }
}

