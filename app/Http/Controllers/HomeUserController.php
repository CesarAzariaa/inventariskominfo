<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeUserController extends Controller
{
    public function homeUser()
    {
        if (Auth::check()) {
            if (Auth::user()->role == 'user') {
                return view('homeUser');
            } else {
                return redirect()->route('login')->with('failed', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
            }
        } else {
            return redirect()->route('login')->with('failed', 'Anda harus login terlebih dahulu.');
        }
    }
}

