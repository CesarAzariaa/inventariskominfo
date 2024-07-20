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
use App\Http\Controllers\AsetKeluarController;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use PDF;

class DataAsetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function data_aset()
    {   
        if (Auth::check()) {
            if (Auth::user()->role == 'admin') {
                $data_aset = Data_aset::join('kategoris', 'data_asets.kategori_id', '=', 'kategoris.id')
                    ->select('data_asets.*', 'kategoris.nama_kategori as nama_kategori')
                    ->whereIn('data_asets.status', ['tersedia', 'terpakai'])
                    ->get();
                $data = array(
                    'data_kategori' => Kategori::all(),
                    'data_aset'     => $data_aset,
                );
                return view('data_aset', $data);
            } else {
                return redirect()->route('login')->with('failed', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
            }
        } else {
            return redirect()->route('login')->with('failed', 'Anda harus login terlebih dahulu.');
        }
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
                $nama_gambar = date('Y-m-d-His').$photo->getClientOriginalName(); // Menambahkan timestamp lebih detail
                $path = 'gambar_aset/'.$nama_gambar;

                Storage::disk('public')->put($path, file_get_contents($photo));
                $validatedData['nama_file'] = $nama_gambar; // Menyimpan nama file yang telah diubah ke dalam array
            }

            $data_aset = Data_aset::create($validatedData);

            // Membuat QR Code dengan URL
            $renderer = new ImageRenderer(
                new RendererStyle(300),
                new SvgImageBackEnd()
            );
            $writer = new Writer($renderer);
            
            // URL untuk detail data aset
            $url = URL::route('detail.data_aset', ['id' => $data_aset->id]);

            // Menulis QR Code dengan URL sebagai string
            $data = $writer->writeString($url);

            $outputPath = 'qr_codes/' . $data_aset->id . '.svg';
            if (!Storage::disk('public')->exists('qr_codes/')) {
                Storage::disk('public')->makeDirectory('qr_codes/');
            }
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
    try {
        $data_aset = Data_aset::findOrFail($id);

        // Tambahkan log untuk melihat nilai variabel
        \Log::info('Input Data: ' . json_encode($request->all()));
        \Log::info('Data Aset sebelum update: ' . json_encode($data_aset));

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

        // Cek apakah ada perubahan pada stok, status, dan tanggal
        $isStatusChanged = $input['status'] != $data_aset->status;
        $isStokChanged = $input['stok'] != $data_aset->stok;
        $isTanggalChanged = $input['tanggal'] != $data_aset->tanggal;

        // Duplikasi data jika stok, status, dan tanggal berubah secara bersamaan
        if ($isStatusChanged && $isStokChanged && $isTanggalChanged) {
            // Buat duplikat data aset yang sudah ada dengan status, tanggal, dan stok yang baru
            $newDataAset = $data_aset->replicate();
            $newDataAset->status = $input['status'];
            $newDataAset->tanggal = $input['tanggal'];
            $newDataAset->stok = $input['stok'];

            // Salin path QR code lama
            $newDataAset->barcode = $data_aset->barcode;

            // Simpan duplikat sebagai data baru
            $newDataAset->save();

            // Kurangi stok dari data aset yang sudah ada
            $data_aset->stok -= $input['stok'];
            
            // Periksa apakah stok menjadi 0
            if ($data_aset->stok <= 0) {
                $data_aset->delete();
            } else {
                $data_aset->save();
            }
        } else {
            // Jika tidak ada perubahan pada status dan stok, hanya update data aset yang sudah ada
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

            // Update data aset yang sudah ada
            $data_aset->update($input);
        }

        // Tambahkan log untuk melihat data aset setelah update
        \Log::info('Data Aset setelah update: ' . json_encode($data_aset));

        return redirect()->route('data_aset')->with('success', 'Data berhasil diperbarui');
    } catch (\Exception $e) {
        return redirect()->route('data_aset')->with('error', 'Gagal memperbarui data aset: ' . $e->getMessage());
    }
}



    public function destroy($id)
    {
        Data_aset::destroy($id);
        
        return redirect('data_aset')->with('success', 'Data berhasil dihapus');
    }

    public function show($id)
    {
        $data_aset = Data_aset::findOrFail($id);

        return view('detail_data_aset', compact('data_aset'));
    }

    public function cetakPdf(Request $request)
    {
        $kategori_id = $request->input('kategori_id');
        $status = $request->input('status');
        $bulan = $request->input('bulan');
        $selected_ids = json_decode($request->input('selected_ids'), true);

        $query = Data_aset::query();

        if (!empty($selected_ids)) {
            $query->whereIn('id', $selected_ids);
        } else {
            if ($kategori_id && $kategori_id !== 'Semua') {
                $query->where('kategori_id', $kategori_id);
            }

            if ($status && $status !== 'Semua') {
                $query->where('status', $status);
            }

            if ($bulan) {
                $query->whereMonth('tanggal', '=', date('m', strtotime($bulan)))
                      ->whereYear('tanggal', '=', date('Y', strtotime($bulan)));
            }
        }

        $data_aset = $query->get();

        $pdf = PDF::loadView('pdf.data-aset', compact('data_aset'));
        return $pdf->download('data-aset.pdf');
    }
}