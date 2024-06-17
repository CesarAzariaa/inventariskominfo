<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Data_Aset; 
use App\Models\Kategori; 
use Illuminate\Support\Facades\Storage;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\LabelAlignment;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Color\Color;

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
    $validatedData = $request->validate([
        'nama_aset' => 'required',
        'kategori_id' => 'required',
        'model' => 'required',
        'merk' => 'required',
        'serial_number' => 'required',
        'stok' => 'required|numeric',
        'status' => 'required',
        'tanggal' => 'required|date',
        'nama_file' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
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

    // Membuat QR Code
    $qrCode = new QrCode($data_aset->id);
    $qrCode->setSize(300);
    $qrCode->setEncoding(new Encoding('UTF-8'));
    $qrCode->setErrorCorrectionLevel(ErrorCorrectionLevel::Low);
    $qrCode->setForegroundColor(new Color(0, 0, 0));
    $qrCode->setBackgroundColor(new Color(255, 255, 255));

    $writer = new PngWriter();
    $result = $writer->write($qrCode);

    // Menyimpan QR Code sebagai file
    $outputPath = 'storage/qr_codes/' . $data_aset->id . '.png';
    $result->saveToFile(public_path($outputPath));

    $data_aset->barcode = $outputPath; // Mengubah 'qr_code_path' menjadi 'barcode'
    $data_aset->save();

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
        'nama_file'     => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    if ($request->hasFile('nama_file')) {
        $image = $request->file('nama_file');
        $fileName = time().'.'.$image->getClientOriginalExtension();
        $image->storeAs('public/gambar_aset', $fileName);
        $validatedData['nama_file'] = $fileName; // Menyimpan nama file yang telah diubah ke dalam array
    }

    Data_Aset::where('id', $id)->update($validatedData);
    return redirect('data_aset')->with('success', 'Data berhasil diupdate');
}

public function destroy($id)
    {
    Data_Aset::destroy($id);
    
    return redirect('data_aset')->with('success', 'Data berhasil dihapus');
    }
}
