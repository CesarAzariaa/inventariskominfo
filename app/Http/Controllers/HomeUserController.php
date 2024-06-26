<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Data_aset;



class HomeUserController extends Controller
{
    public function homeUser()
    {
        if (Auth::check()) {
            if (Auth::user()->role == 'user') {
                $data_aset = Data_aset::all();
                
                // Mengumpulkan data untuk chart berdasarkan bulan dan tahun dengan memastikan semua bulan ditampilkan
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

                // Menambahkan data aset tersedia dan terpakai, serta dipinjam dan rusak
                $data_aset_tersedia_terpakai = \App\Models\Data_aset::whereIn('status', ['tersedia', 'terpakai'])->get();
                $data_aset_dipinjam_rusak = \App\Models\Data_aset::whereIn('status', ['dipinjam', 'rusak'])->get();

                // Menghitung jumlah data aset berdasarkan bulan
                $dataAsetMasuk = $data_aset_tersedia_terpakai->groupBy(function($date) {
                    return \Carbon\Carbon::parse($date->tanggal)->format('M'); // grouping by months
                })->map->count();

                $dataAsetKeluar = $data_aset_dipinjam_rusak->groupBy(function($date) {
                    return \Carbon\Carbon::parse($date->tanggal)->format('M'); // grouping by months
                })->map->count();

                return view('homeUser', [
                    'data_aset' => $data_aset,
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

