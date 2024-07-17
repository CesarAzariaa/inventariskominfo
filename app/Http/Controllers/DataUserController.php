<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class DataUserController extends Controller
{
    public function datauser()
    {
        $data = array(
            'data_user' => User::all()
        );
        return view('datauser', $data);
    }

    public function store(Request $request)
    {
    $request->validate([
        'nama' => 'required',
        'username' => 'required|unique:users',
        'no_handphone' => 'required',
        'asal_instansi' => 'required',
        'password' => 'required|min:8',
        'role' => 'required',
    ]);

    User::create([
        'nama' => $request->nama,
        'username' => $request->username,
        'no_handphone' => $request->no_handphone,
        'asal_instansi' => $request->asal_instansi,
        'password' => Hash::make($request->password),
        'role' => $request->role, 
    ]);

    return redirect('/datauser')->with('success', 'Data berhasil ditambahkan');
}

    public function update(Request $request, $id)
    {
    $request->validate([
        'nama' => 'required',
        'username' => [
            'required',
            Rule::unique('users')->ignore($id),
        ],
        'no_handphone' => 'required',
        'asal_instansi' => 'required',
        'password' => 'required|min:8',
        'role' => 'required',
    ]);

    $user = User::find($id);

    $user->update([
        'nama' => $request->nama,
        'username' => $request->username,
        'no_handphone' => $request->no_handphone,
        'asal_instansi' => $request->asal_instansi,
        'password' => Hash::make($request->password),
        'role' => $request->role,
    ]);

    return redirect('/datauser')->with('success', 'Data berhasil diperbarui');
}

    public function destroy($id)
    {
        $user = User::find($id);

        $user->delete();
            
        return redirect('/datauser')->with('success', 'Data berhasil dihapus');
    }
}