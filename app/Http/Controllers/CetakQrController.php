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
    
    Log::info('Data Aset:', $data_aset->toArray());
    
    return view('cetak-qr-code', compact('data_aset','data_kategori'));
}


public function qrCodePdf(Request $request) 
    {
        $data_aset = Data_aset::with('kategori')->get();
        $data_kategori = Kategori::all();
        
        $pdf = new Mpdf();
        $pdf->SetTitle('QR Code');
        $pdf->SetFont('Arial', '', 12);
        $pdf->AddPage();
        
        $content = view('pdf.qr-code-pdf', compact('data_aset', 'data_kategori'))->render();
        $pdf->WriteHTML($content);
        $pdf->Output('qr-code.pdf', 'D');
    }

}