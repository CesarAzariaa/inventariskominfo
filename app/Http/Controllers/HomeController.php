<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Data_aset;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        return view('landing');
    }

    public function home()
{
    if (Auth::check()) {
        if (Auth::user()->role == 'admin') {
            $data_aset = Data_aset::all();
            $data_user = User::all();
            
            // Mengumpulkan data untuk chart berdasarkan bulan
            $chart_data = Data_aset::selectRaw('MONTH(tanggal) as bulan, count(*) as jumlah')
                                    ->whereIn('status', ['tersedia', 'terpakai'])
                                    ->groupBy('bulan')
                                    ->orderBy('bulan')
                                    ->get();
            
            return view('home', compact('data_aset', 'data_user', 'chart_data'));
        } else {
            return redirect()->route('login')->with('failed', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
    } else {
        return redirect()->route('login')->with('failed', 'Anda harus login terlebih dahulu.');
    }
}



}
