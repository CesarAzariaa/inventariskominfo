<!DOCTYPE html>
<html>
<head>
    <title>QR Code Data Aset</title>
    <style>
        .header {
            background-color: #3498db;
            color: white;
            padding: 5px;
            text-align: center;
            font-size: 10px;
            border-radius: 10px 10px 0 0;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-start; /* Mengatur agar item mulai dari kiri */
        }

        .card {
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 10px;
            margin: 5px;
            width: 120px;
            height: 180px;
            box-sizing: border-box;
            background-color: #f9f9f9;
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 0 0 auto; /* Menjaga ukuran tetap */
        }

        .card-content {
            text-align: center;
            margin-bottom: 10px;
        }

        .card .qr-code {
            text-align: center;
        }

        .card .qr-code img {
            width: 70px;
            height: 70px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .card .qr-code p {
            margin-top: 5px;
            color: #2980b9;
            font-size: 10px;
        }

        h2 {
            margin-top: 20px; /* Menambahkan margin atas */
        }
    </style>
</head>
<body>
    <h2>QR Code Data Aset</h2>
    <div class="container">
        @foreach ($expandedDataAsets as $row)
            <div class="card">
                <div class="card-content">
                    <div class="header">Diskominfotik Bengkalis</div>
                    <p>{{ $row->nama_aset }}</p>
                </div>
                <div class="qr-code">
                    @if ($row->barcode && file_exists(storage_path('app/public/' . $row->barcode)))
                        <img src="{{ public_path('storage/' . $row->barcode) }}" alt="QR Code" />
                        <p>Scan untuk melihat detail produk</p> <!-- Mengubah teks -->
                    @else
                        <p>QR Code tidak ditemukan</p>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</body>
</html>