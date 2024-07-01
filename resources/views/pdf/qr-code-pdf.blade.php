<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="assets/img/icon.ico" type="image/x-icon"/>
    <title>QR Code PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
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
            border: 1px solid rgb(220, 46, 46);
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tbody tr:hover {
            background-color: #f1f1f1;
        }
        img {
            display: block;
            margin-left: auto;
            margin-right: auto;
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
