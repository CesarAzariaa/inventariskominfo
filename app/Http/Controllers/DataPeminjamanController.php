<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DataPeminjamanController extends Controller
{
    public function data_peminjaman()
    {
        return view('data_peminjaman');
    }
}
