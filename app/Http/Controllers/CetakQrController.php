<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Data_aset;
use App\Models\Kategori;
use Mpdf\Mpdf;
use Log;

class CetakQrController extends Controller
{
    public function cetak_qr() 
    {
        $data_aset = Data_aset::with('kategori')->get();
        $data_kategori = Kategori::all();
        
        Log::info('Data Aset:', $data_aset->toArray());
        
        return view('cetak-qr-code', compact('data_aset', 'data_kategori'));
    }

    public function cetakPDF(Request $request)
    {
        $selectedAsetIds = explode(',', $request->input('selected_ids', ''));

        // Log untuk memeriksa data yang diterima
        Log::info('Selected Aset IDs:', ['selected_aset_ids' => $selectedAsetIds]);

        // Filter data_asets berdasarkan selected_aset_ids jika ada
        $data_asets = Data_aset::with('kategori')
            ->whereIn('id', $selectedAsetIds)
            ->get();

        // Membuat array untuk menyimpan data aset sesuai dengan jumlah stok
        $expandedDataAsets = [];

        foreach ($data_asets as $data_aset) {
            for ($i = 0; $i < $data_aset->stok; $i++) {
                $expandedDataAsets[] = $data_aset;
            }
        }

        // Mengirimkan data aset yang diperluas ke tampilan PDF
        $html = view('pdf.qr-code-pdf', compact('expandedDataAsets'))->render();

        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);
        return $mpdf->Output('qr_data_aset.pdf', 'D');
    }
}
