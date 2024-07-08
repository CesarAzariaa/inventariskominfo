<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Data_aset;
use App\Models\Kategori;
use Mpdf\Mpdf;

class CetakAsetController extends Controller
{
    public function cetak() 
    {
        $data_aset = Data_aset::with('kategori')->get();
        $data_kategori = Kategori::all();
    
        return view('cetak-data-aset', compact('data_aset','data_kategori'));
    }

    public function dataAsetPdf(Request $request) 
{
    $kategori = $request->input('kategori_id');
    $status = $request->input('status');
    $bulan = $request->input('bulan');

    $data_aset = Data_aset::with('kategori')
        ->when($kategori && $kategori !== "all", function ($query, $kategori) {
            return $query->whereHas('kategori', function ($query) use ($kategori) {
                $query->where('id', $kategori);
            });
        })
        ->when($status && $status !== "all", function ($query, $status) {
            return $query->where('status', $status);
        })
        ->when($bulan, function ($query, $bulan) {
            return $query->whereMonth('tanggal', date('m', strtotime($bulan)))
                         ->whereYear('tanggal', date('Y', strtotime($bulan)));
        })
        ->get();

    if ($data_aset->isEmpty()) {
        return redirect()->back()->with('error', 'Tidak ada data aset yang sesuai dengan filter yang dipilih.');
    }

    // Inisialisasi Mpdf
    $mpdf = new Mpdf();

    // Tambahkan CSS untuk styling
    $stylesheet = '
    <style>
        body {
            font-family: sans-serif;
            margin: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #428dfd;
            color: #ffffff;
        }
        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tbody tr:hover {
            background-color: #f1f1f1;
        }
        tbody td {
            color: #000000; 
        }
        img {
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
    ';
    $mpdf->WriteHTML($stylesheet, 1);

    // Buat konten HTML untuk PDF
    $html = '<h1>Data Aset</h1>';
    $html .= '<table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Aset</th>
                        <th>Kategori</th>
                        <th>Merk</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>';
    
    $no = 1;
    foreach ($data_aset as $aset) {
        $html .= '<tr>
                    <td>' . $no++ . '</td>
                    <td>' . $aset->nama_aset . '</td>
                    <td>' . $aset->kategori->nama_kategori . '</td>
                    <td>' . $aset->merk . '</td>
                    <td>' . $aset->stok . '</td>
                    <td>' . $aset->status . '</td>
                    <td>' . $aset->tanggal . '</td>
                  </tr>';
    }

    $html .= '</tbody></table>';

    // Tulis HTML ke PDF
    $mpdf->WriteHTML($html);

    // Tambahkan header dan footer
    $mpdf->SetHTMLHeader('<div style="text-align: right;">Data Aset</div>');
    $mpdf->SetHTMLFooter('<div style="text-align: center;">{PAGENO}</div>');

    // Output PDF ke browser
    $mpdf->Output('data-aset.pdf', 'I');
}

}

