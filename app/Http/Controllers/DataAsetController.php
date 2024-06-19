<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Data_aset; 
use App\Models\Kategori; 
use Illuminate\Support\Facades\Storage;
use BaconQrCode\Writer;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;

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
    try {
        $validatedData = $request->validate([
            'nama_aset' => 'required',
            'kategori_id' => 'required',
            'model' => 'required',
            'merk' => 'required',
            'stok' => 'required|numeric',
            'status' => 'required',
            'tanggal' => 'required|date',
            'nama_file' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'barcode' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('nama_file')) {
            $photo = $request->file('nama_file');
            $nama_gambar = date('Y-m-d').$photo->getClientOriginalName();
            $path = 'gambar_aset/'.$nama_gambar;

            Storage::disk('public')->put($path, file_get_contents($photo));
            $validatedData['nama_file'] = $nama_gambar; // Menyimpan nama file yang telah diubah ke dalam array
        }

        $data_aset = Data_Aset::create($validatedData);

        // Membuat QR Code dengan BaconQrCode
        $renderer = new ImageRenderer(
            new RendererStyle(300),
            new SvgImageBackEnd()
        );
        $writer = new Writer($renderer);
        $outputPath = 'qr_codes/' . $data_aset->id . '.svg';
        if (!Storage::disk('public')->exists('qr_codes/')) {
            Storage::disk('public')->makeDirectory('qr_codes/');
        }
        $data = $writer->writeString($data_aset->id);
        Storage::disk('public')->put($outputPath, $data);

        $data_aset->barcode = $outputPath;
        $data_aset->save();

        return redirect()->route('data_aset')->with('success', 'Data aset berhasil ditambahkan.');
    } catch (\Exception $e) {
        return redirect()->route('data_aset')->with('error', 'Gagal menambahkan data aset: ' . $e->getMessage());
    }
}

public function update(Request $request, $id)
{
    $validatedData = $request->validate([
        'kategori_id'   => 'required',
        'nama_aset'     => 'required',
        'model'         => 'required',
        'merk'          => 'required',
        'stok'          => 'required|numeric',
        'status'        => 'required',
        'tanggal'       => 'required|date',
        'nama_file'     => 'sometimes|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $dataAset = Data_Aset::findOrFail($id);

    if ($request->hasFile('nama_file')) {
        // Hapus file lama jika ada
        $oldFileName = $dataAset->nama_file;
        if ($oldFileName && Storage::disk('public')->exists("gambar_aset/$oldFileName")) {
            Storage::disk('public')->delete("gambar_aset/$oldFileName");
        }

        // Simpan file baru
        $image = $request->file('nama_file');
        $fileName = time() . '.' . $image->getClientOriginalExtension();
        $image->storeAs('public/gambar_aset', $fileName);
        $validatedData['nama_file'] = $fileName;
    }

    try {
        $dataAset->update($validatedData);
        return redirect('data_aset')->with('success', 'Data berhasil diupdate');
    } catch (\Exception $e) {
        return back()->with('error', 'Gagal mengupdate data: ' . $e->getMessage());
    }
}

public function destroy($id)
    {
    Data_Aset::destroy($id);
    
    return redirect('data_aset')->with('success', 'Data berhasil dihapus');
    }
}
