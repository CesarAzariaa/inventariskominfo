@extends('layout.layout')

@section('content')
    
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="home">
                            <i class="flaticon-home"></i>
                        </a>
                    </li>
                    <li class="separator">
                        <i class="flaticon-right-arrow"></i>
                    </li>
                    <li class="nav-item">
                        <a href="">Laporan Cetak</a>
                    </li>
                    <li class="separator">
                        <i class="flaticon-right-arrow"></i>
                    </li>
                    <li class="nav-item">
                        <a href="data_aset">Data Aset</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Cetak Data Aset</h4>
                            </div>
                            <form action="{{ route('data-aset-pdf') }}" method="GET">
                                <div class="form-group">
                                    <label for="filter-kategori">Pilih Kategori</label>
                                    <select id="filter-kategori" name="kategori_id" class="form-control">
                                        <option value="">Semua</option>
                                        @foreach ($data_kategori as $kat)
                                            <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group text-left">
                                    <button type="submit" class="btn btn-primary">Cetak PDF</button>
                                </div>
                            </form>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="add-row" class="display table table-striped table-hover">
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
                                            <tr class="aset-row" data-kategori="{{ $row->kategori->nama_kategori }}">
                                                <td>{{$no++}}</td>
                                                <td>{{$row->nama_aset}}</td>
                                                <td>{{$row->kategori->nama_kategori}}</td>
                                                <td>{{$row->merk}}</td>
                                                <td>{{$row->stok}} Pcs</td>
                                                <td>{{$row->status}}</td>
                                                <td>{{$row->tanggal}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('filter-kategori').addEventListener('change', function() {
        var kategori = this.options[this.selectedIndex].text; // Ambil teks dari opsi yang dipilih
        console.log("Kategori yang dipilih: ", kategori); // Tambahkan ini untuk debugging
        var rows = document.querySelectorAll('.aset-row');
        rows.forEach(function(row) {
            var rowKategori = row.getAttribute('data-kategori');
            console.log("Kategori pada baris: ", rowKategori); // Tambahkan ini untuk debugging
            if (kategori === "Semua" || rowKategori === kategori) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    });
</script>

@endsection
