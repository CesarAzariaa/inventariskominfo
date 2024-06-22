<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Data_aset; 
use App\Models\Kategori;

class AsetUserController extends Controller
{
    public function aset_user()
    {
        // Mengambil semua data aset beserta kategori_id
        $data_aset = Data_Aset::with('kategori')->get();

        // Memastikan bahwa data kategori juga dikirim ke view
        return view('data_asetUser', ['data_aset' => $data_aset]);
    }
}
