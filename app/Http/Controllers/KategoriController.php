<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori; 

class KategoriController extends Controller
{
    public function kategori()
    {
        $data = array(
            'data_kategori' => Kategori::all()
        );
        return view('kategori', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string', 
        ]);

        $kategori = new Kategori;
        $kategori->nama_kategori = $request->nama_kategori;
        $kategori->save();

        return redirect()->back()->with('success', 'Data berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $kategori = Kategori::find($id);

            $kategori->update([
                'nama_kategori' => $request->nama_kategori,
            ]);
            return redirect()->back()->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $kategori = Kategori::find($id);

        $kategori = Kategori::find($id);

        if ($kategori) {
            $kategori->delete();
            return redirect('/kategori')->with('success', 'Data berhasil dihapus');
        } else {
            return redirect('/kategori')->with('error', 'Kategori tidak ditemukan');
        }
    }
}
