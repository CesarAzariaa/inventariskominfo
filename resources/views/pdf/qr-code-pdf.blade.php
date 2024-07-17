<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="assets/img/icon.ico" type="image/x-icon"/>
    <title>QR Code PDF</title>
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
</head>
<body>
    <h1>Data Aset</h1>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Aset</th>
                <th>Kategori</th>
                <th>Merk</th>
                <th>Model</th>
                <th>Stok</th>
                <th>QR Code</th>
            </tr>
        </thead>
        <tbody>
            @php $no=1 @endphp
            @foreach ($data_aset as $row)
                <tr>
                    <td>{{$no++}}</td>
                    <td>{{$row->nama_aset}}</td>
                    <td>{{$row->kategori->nama_kategori}}</td>
                    <td>{{$row->merk}}</td>
                    <td>{{$row->model}}</td>
                    <td>{{$row->stok}}</td>
                    <td>
                        <img src="{{ asset('storage/qr_codes/' . $row->id . '.svg') }}" alt="QR Code" style="width: 50px; height: 50px;" />
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
