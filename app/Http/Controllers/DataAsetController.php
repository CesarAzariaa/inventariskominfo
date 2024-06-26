<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Data_aset; 
use App\Models\Kategori; 
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use BaconQrCode\Writer;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use App\Http\Controllers\AsetKeluarController;

class DataAsetController extends Controller
{
    public function data_aset()
{
    $data_aset = Data_aset::join('kategoris', 'data_asets.kategori_id', '=', 'kategoris.id')
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

        $data_aset = Data_aset::create($validatedData);

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
    $data_aset = Data_aset::findOrFail($id);

    // Validasi input termasuk file gambar
    $validatedData = $request->validate([
        'nama_aset' => 'required',
        'kategori_id' => 'required',
        'model' => 'required',
        'merk' => 'required',
        'stok' => 'required|numeric',
        'status' => 'required',
        'tanggal' => 'required|date',
        'nama_file' => 'sometimes|image|mimes:jpeg,png,jpg|max:2048', 
    ]);

    $input = $validatedData; 

    if ($request->hasFile('nama_file')) {
        if ($data_aset->nama_file) {
            $oldPath = 'gambar_aset/' . $data_aset->nama_file;
            if (Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
        }

        $photo = $request->file('nama_file');
        $nama_gambar = date('Y-m-d-His') . '-' . $photo->getClientOriginalName(); // Menambahkan timestamp lebih detail
        $path = 'gambar_aset/' . $nama_gambar;

        // Simpan gambar baru ke dalam storage
        Storage::disk('public')->put($path, file_get_contents($photo));

        // Simpan nama file yang baru diupdate ke dalam input
        $input['nama_file'] = $nama_gambar;
    }

    // Proses update data
    $data_aset->update($input);

    // Mengurangi stok jika status adalah "dipinjam" atau "rusak"
    if (in_array($input['status'], ['dipinjam', 'rusak'])) {
        $jumlah_keluar = $request->input('jumlah_keluar', 0);
        if ($jumlah_keluar > 0 && $jumlah_keluar <= $data_aset->stok) {
            $data_aset->stok -= $jumlah_keluar;
            $data_aset->save();

            // Menambahkan data ke AsetKeluarController
            $asetKeluarController = new AsetKeluarController();
            $asetKeluarController->store([
                'data_aset_id' => $data_aset->id,
                'jumlah' => $jumlah_keluar,
                'status' => $input['status'],
                'tanggal' => now(),
            ]);
        }
    }

    return redirect()->route('data_aset')->with('success', 'Data berhasil diperbarui');
}

public function destroy($id)
    {
    Data_aset::destroy($id);
    
    return redirect('data_aset')->with('success', 'Data berhasil dihapus');
    }
}
