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
                
                // Query untuk mengambil data aset masuk dan keluar berdasarkan bulan
                $chart_data = \DB::table(\DB::raw('(
                    SELECT 1 AS bulan UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6
                    UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION SELECT 10 UNION SELECT 11 UNION SELECT 12
                ) months'))
                ->leftJoin(\DB::raw('(SELECT MONTH(tanggal) as bulan, YEAR(tanggal) as tahun, count(*) as jumlah
                                     FROM data_asets
                                     WHERE status IN ("tersedia", "terpakai", "dipinjam", "rusak")
                                     GROUP BY bulan, tahun) as data'), function($join) {
                                         $join->on('months.bulan', '=', 'data.bulan');
                                     })
                ->select('months.bulan', 'data.tahun', \DB::raw('IFNULL(data.jumlah, 0) as jumlah'))
                ->orderBy('data.tahun')
                ->orderBy('months.bulan')
                ->get();

                // Query untuk menghitung data aset masuk
                $data_aset_tersedia_terpakai = Data_aset::whereIn('status', ['tersedia', 'terpakai'])->get();
                $dataAsetMasuk = $data_aset_tersedia_terpakai->groupBy(function($date) {
                    return \Carbon\Carbon::parse($date->tanggal)->format('M'); // grouping by months
                })->map->count();

                // Query untuk menghitung data aset keluar
                $data_aset_dipinjam_rusak = Data_aset::whereIn('status', ['dipinjam', 'rusak'])->get();
                $dataAsetKeluar = $data_aset_dipinjam_rusak->groupBy(function($date) {
                    return \Carbon\Carbon::parse($date->tanggal)->format('M'); // grouping by months
                })->map->count();

                return view('home', [
                    'data_aset' => $data_aset,
                    'data_user' => $data_user,
                    'chart_data' => $chart_data,
                    'dataAsetMasuk' => $dataAsetMasuk,
                    'dataAsetKeluar' => $dataAsetKeluar
                ]);
            } else {
                return redirect()->route('login')->with('failed', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
            }
        } else {
            return redirect()->route('login')->with('failed', 'Anda harus login terlebih dahulu.');
        }
    }
}

