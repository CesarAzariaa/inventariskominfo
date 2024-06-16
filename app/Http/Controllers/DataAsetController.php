<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Data_Aset; 
use App\Models\Kategori; 

class DataAsetController extends Controller
{
    public function data_aset()
{
    $data_aset = Data_Aset::join('kategoris', 'data_asets.kategori_id', '=', 'kategoris.id')
                  ->select('data_asets.*', 'kategoris.nama_kategori as nama_kategori')
                  ->get();
    $data = array(
        'data_kategori' => Kategori::all(),
        'data_aset'     => $data_aset,
    );
    return view('data_aset', $data);
}


public function store(Request $request)
{
    // Validasi data
    $validatedData = $request->validate([
        'nama_aset' => 'required',
        'kategori_id' => 'required',
        'model' => 'required',
        'merk' => 'required',
        'serial_number' => 'required',
        'stok' => 'required|numeric',
        'status' => 'required',
        'tanggal' => 'required|date',
    ]);

    // Simpan data ke dalam database
    Data_Aset::create($validatedData);

    // Redirect ke halaman yang sesuai setelah penyimpanan berhasil
    return redirect()->route('data_aset')->with('success', 'Data aset berhasil ditambahkan.');
}



    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'kategori_id'   => 'required',
            'nama_aset'     => 'required',
            'model'         => 'required',
            'merk'          => 'required',
            'serial_number' => 'required',
            'stok'          => 'required',
            'status'        => 'required',
            'tanggal'       => 'required',
        ]);

        Data_Aset::where('id', $id)->update($validatedData);

        return redirect('data_aset')->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        Data_Aset::destroy($id);

        return redirect('data_aset')->with('success', 'Data berhasil dihapus');
    }
}
