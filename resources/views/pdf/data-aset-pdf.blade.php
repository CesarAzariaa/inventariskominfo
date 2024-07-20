<!DOCTYPE html>
<html>
<head>
    <title>Data Aset</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h2>Data Aset</h2>
    <table>
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
        <tbody>
            @php $no=1 @endphp
            @foreach ($data_aset as $row)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $row->nama_aset }}</td>
                    <td>{{ $row->kategori->nama_kategori }}</td>
                    <td>{{ $row->merk }}</td>
                    <td>{{ $row->stok }} Pcs</td>
                    <td>{{ $row->status }}</td>
                    <td>{{ \Carbon\Carbon::parse($row->tanggal)->translatedFormat('d M Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
