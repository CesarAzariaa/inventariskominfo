<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Data_aset; 

class AsetUserController extends Controller
{
    public function aset_user()
    {
        $data_aset = Data_Aset::all();

        return view('data_asetUser', ['data_aset' => $data_aset]);
    }
}
    

