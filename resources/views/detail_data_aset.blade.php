<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Data Aset</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card-header {
            background: linear-gradient(90deg, #007bff 0%, #00c6ff 100%);
        }
        .card-body {
            background: #f9f9f9;
        }
        .row {
            margin-bottom: 10px;
        }
        .text-title {
            font-weight: bold;
            color: #000000;
        }
        .text-value {
            color: #000000;
        }
        .qr-code {
            margin-top: 20px;
        }
        .image-preview {
            max-width: 100%;
            height: auto;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header text-white text-center">
                    <h4>Detail Data Aset</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div style="width: 200px; height: 200px; display: flex; justify-content: center; align-items: center; border: 1px solid #ccc;">
                            <img src="{{ url('storage/gambar_aset/' . $data_aset->nama_file) }}" alt="File Image" class="img-fluid image-preview" style="max-width: 100%; max-height: 100%; display: block;">
                        </div>
                                               
                    </div>
                    <div class="row">
                        <div class="col-sm-3 text-title">
                            Nama Aset:
                        </div>
                        <div class="col-sm-9 text-value">
                            {{ $data_aset->nama_aset }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 text-title">
                            Kategori:
                        </div>
                        <div class="col-sm-9 text-value">
                            {{ $data_aset->kategori->nama_kategori }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 text-title">
                            Model:
                        </div>
                        <div class="col-sm-9 text-value">
                            {{ $data_aset->model }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 text-title">
                            Merk:
                        </div>
                        <div class="col-sm-9 text-value">
                            {{ $data_aset->merk }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 text-title">
                            Stok:
                        </div>
                        <div class="col-sm-9 text-value">
                            {{ $data_aset->stok }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 text-title">
                            Status:
                        </div>
                        <div class="col-sm-9 text-value">
                            {{ $data_aset->status }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 text-title">
                            Tanggal:
                        </div>
                        <div class="col-sm-9 text-value">
                            {{ $data_aset->tanggal }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
