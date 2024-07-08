<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Data_aset;
use App\Models\Kategori;
use Mpdf\Mpdf;
use Log;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

class CetakQrController extends Controller
{
    public function cetak_qr() 
{
    $data_aset = Data_aset::with('kategori')->get();
    $data_kategori = Kategori::all();
    
    // Log data untuk debugging
    Log::info('Data Aset:', $data_aset->toArray());
    
    return view('cetak-qr-code', compact('data_aset','data_kategori'));
}


public function cetak_qr_pdf(Request $request) 
{
    $kategori_id = $request->input('kategori_id');
    $data_aset = Data_aset::with('kategori')
        ->when($kategori_id, function($query) use ($kategori_id) {
            return $query->where('kategori_id', $kategori_id);
        })
        ->get()
        ->groupBy('nama_aset');

    // Log data untuk debugging
    Log::info('Data Aset:', $data_aset->toArray());

    if ($data_aset->isEmpty()) {
        return redirect()->back()->with('error', 'Tidak ada data yang sesuai dengan filter yang dipilih.');
    }

    try {
        $mpdf = new Mpdf();

        $stylesheet = '
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 100px;
            }
            .card-container {
                display: flex;
                flex-wrap: wrap;
                justify-content: flex-start;
            }
            .card {
                border: 2px solid #000000;
                border-radius: 10px;
                padding: 10px;
                margin: 10px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                width: 18%; /* Sesuaikan width agar pas dua kartu per baris */
                display: flex;
                align-items: flex;
                justify-content: center;
            }
            .card img {
                width: 100px;
                height: 100px;
            }
            .card .content {
                flex: 1;
                margin-left: 10px;
            }
            .card .qr-code {
                margin-left: 10px;
            }
        </style>
        ';
        $mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);

        foreach ($data_aset as $nama_aset => $assets) {
            $html = '<h1>Qr Code Data Aset - ' . $nama_aset . '</h1>';
            $html .= '<div class="card-container">';

            foreach ($assets as $aset) {
                $result = Builder::create()
                    ->writer(new PngWriter())
                    ->data($aset->barcode)
                    ->build();
                
                $qrcode = base64_encode($result->getString());

                for ($i = 0; $i < $aset->stok; $i++) {
                    $html .= '<div class="card">
                                <img src="' . asset('assets/img/kominfo.png') . '" alt="Logo" />
                                <div class="content">
                                    <p>Nama: ' . $aset->nama_aset . '</p>
                                    <p>Kategori: ' . $aset->kategori->nama_kategori . '</p>
                                    <p>Merk: ' . $aset->merk . '</p>
                                    <p>Model: ' . $aset->model . '</p>
                                    <p>Merk: ' . $aset->status . '</p>
                                </div>
                                <div class="qr-code">
                                    <img src="data:image/png;base64,' . $qrcode . '" alt="QR Code"/>
                                </div>
                              </div>';
                }
            }

            $html .= '</div>';
            $mpdf->AddPage();
            $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);
        }

        $mpdf->SetHTMLHeader('<div style="text-align: right;">Data Aset</div>');
        $mpdf->SetHTMLFooter('<div style="text-align: center;">{PAGENO}</div>');

        $mpdf->Output('data-aset.pdf', 'I');
    } catch (\Mpdf\MpdfException $e) {
        Log::error('Mpdf error: ' . $e->getMessage());
        return response()->json(['error' => 'PDF generation failed.'], 500);
    }
}

}
