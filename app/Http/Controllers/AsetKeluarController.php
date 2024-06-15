<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Data_aset; 

class AsetKeluarController extends Controller
{
    public function aset_keluar()
    {
        $data_aset = Data_Aset::all();

        return view('data_asetKeluar', ['data_aset' => $data_aset]);
    }
}
