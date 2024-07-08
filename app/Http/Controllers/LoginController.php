<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function loginProses(Request $request)
    {
        $data = $request->only('username', 'password');

        if (Auth::attempt($data)) {
            $user = Auth::user();
            if ($user->role == 'admin') {
                return redirect()->route('home')->with('success', 'Login Berhasil!');
            } elseif ($user->role == 'user') {
                return redirect()->route('homeUser')->with('success', 'Login Berhasil!');
            }
        } 

        // Jika autentikasi gagal atau peran tidak sesuai
        return redirect()->route('login')->with('failed', 'Username atau Password Salah');
    }

    public function logoutProses()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Anda Berhasil Logout');
    }

    public function register()
    {
        return view('register');
    }

    public function registerProses(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'username' => 'required|unique:users',
            'no_handphone' => 'required',
            'asal_instansi' => 'required',
            'password' => 'required|min:8',
            'chat_id' => 'nullable|string' 
        ]);

        $data['nama'] = $request->nama;
        $data['username'] = $request->username;
        $data['no_handphone'] = $request->no_handphone;
        $data['asal_instansi'] = $request->asal_instansi;   
        $data['password'] = Hash::make($request->password);
        $data['chat_id'] = $request->chat_id; 
        User::create($data);

        $login = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        if (Auth::attempt($login)) {
            return redirect()->route('login')->with('success', 'Pendaftaran Berhasil Silahkan Login');
        } else {
            return redirect()->route('login')->with('failed', 'Username atau Password Salah');
        }
    }
}

