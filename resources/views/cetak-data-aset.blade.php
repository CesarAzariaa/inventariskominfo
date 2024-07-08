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
                            <form id="cetak-form" action="{{ route('data-aset.pdf') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="filter-kategori">Pilih Kategori</label>
                                    <select id="filter-kategori" name="kategori_id" class="form-control">
                                        <option value="">Pilih sesuai kebutuhan</option>
                                        <option value="">Semua</option>
                                        @foreach ($data_kategori as $kat)
                                            <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="filter-status">Pilih Status</label>
                                    <select id="filter-status" name="status" class="form-control">
                                        <option value="">Pilih sesuai kebutuhan</option>
                                        <option value="">Semua</option>
                                        <option value="tersedia">Tersedia</option>
                                        <option value="terpakai">Terpakai</option>
                                        <option value="dipinjam">Dipinjam</option>
                                        <option value="rusak">Rusak</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="filter-bulan">Pilih Bulan</label>
                                    <input type="month" id="filter-bulan" name="bulan" class="form-control" placeholder="Pilih sesuai kebutuhan">
                                </div>
                                <div class="form-group text-left">
                                    <button type="button" id="cetak-button" class="btn btn-primary">Cetak PDF</button>
                                </div>
                            </form>                                                  
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="add-row" class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="select-all-checkbox"></th>
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
                                            <tr class="aset-row" data-kategori="{{ $row->kategori->id }}" data-tanggal="{{ $row->tanggal }}">
                                                <td><input type="checkbox" class="row-checkbox" name="selected_ids[]" value="{{ $row->id }}"></td>
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
    function filterRows() {
        var kategori = document.getElementById('filter-kategori').value;
        var status = document.getElementById('filter-status').value;
        var bulan = document.getElementById('filter-bulan').value;
        
        var rows = document.querySelectorAll('.aset-row');
        var dataAvailable = false;

        rows.forEach(function(row) {
            var rowKategori = row.getAttribute('data-kategori');
            var rowStatus = row.querySelector('td:nth-child(7)').innerText.toLowerCase();
            var rowTanggal = row.getAttribute('data-tanggal').substring(0, 7);

            var showRow = true;

            if (kategori && kategori !== "Pilih sesuai kebutuhan" && kategori !== "Semua" && rowKategori != kategori) {
                showRow = false;
            }

            if (status && status !== "Pilih sesuai kebutuhan" && rowStatus !== status) {
                showRow = false;
            }

            if (bulan && rowTanggal !== bulan) {
                showRow = false;
            }

            if (showRow) {
                row.style.display = "";
                dataAvailable = true;
            } else {
                row.style.display = "none";
            }
        });

        return dataAvailable;
    }

    document.getElementById('filter-kategori').addEventListener('change', filterRows);
    document.getElementById('filter-status').addEventListener('change', filterRows);
    document.getElementById('filter-bulan').addEventListener('change', filterRows);

    document.getElementById('select-all-checkbox').addEventListener('change', function() {
        var isChecked = this.checked;
        var checkboxes = document.querySelectorAll('.row-checkbox');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = isChecked;
        });
    });

    document.getElementById('cetak-button').addEventListener('click', function() {
    var kategori = document.getElementById('filter-kategori').value;
    var status = document.getElementById('filter-status').value;
    var bulan = document.getElementById('filter-bulan').value;

    var form = document.getElementById('cetak-form');

    // Set nilai filter ke dalam input tersembunyi
    var inputKategori = document.createElement('input');
    inputKategori.type = 'hidden';
    inputKategori.name = 'kategori_id';
    inputKategori.value = kategori;
    form.appendChild(inputKategori);

    var inputStatus = document.createElement('input');
    inputStatus.type = 'hidden';
    inputStatus.name = 'status';
    inputStatus.value = status;
    form.appendChild(inputStatus);

    var inputBulan = document.createElement('input');
    inputBulan.type = 'hidden';
    inputBulan.name = 'bulan';
    inputBulan.value = bulan;
    form.appendChild(inputBulan);

    form.submit();
});

</script>
@endsection
