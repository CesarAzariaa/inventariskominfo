@extends('layout.layout')

@section('content')
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <!-- Breadcrumbs -->
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Cetak Data Aset</h4>
                            </div>
                            <form id="cetak-form" action="{{ route('qr-code-pdf') }}" method="GET">
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
                                    <button type="button" id="cetak-button" class="btn btn-danger">
                                        <i class="fa fa-file"></i> Cetak PDF
                                    </button>
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
                                            <th>Model</th>
                                            <th>Stok</th>
                                            <th>Status</th>
                                            <th>QR Code</th>
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
                                                <td>{{ $row->model }}</td>
                                                <td>{{$row->stok}} Pcs</td>
                                                <td>{{$row->status}}</td>
                                                <td>
                                                    @php
                                                        $qrCodeUrl = asset('storage/' . $row->barcode);
                                                        $qrCodePath = storage_path('app/public/' . $row->barcode);
                                                        if (!file_exists($qrCodePath)) {
                                                            \Log::error('QR Code file not found for asset ID: ' . $row->id);
                                                        }
                                                    @endphp
                                                    @if (file_exists($qrCodePath))
                                                        <img src="{{ $qrCodeUrl }}" alt="QR Code" style="width: 70px; height: 70px;" />
                                                    @else
                                                        <p>QR Code not found</p>
                                                    @endif
                                                </td>
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    document.getElementById('filter-kategori').addEventListener('change', function() {
        var kategori = this.options[this.selectedIndex].text;
        console.log("Kategori yang dipilih: ", kategori);
        var rows = document.querySelectorAll('.aset-row');
        var dataAvailable = false;
        rows.forEach(function(row) {
            var rowKategori = row.getAttribute('data-kategori');
            console.log("Kategori pada baris: ", rowKategori);
            if (kategori === "Semua" || rowKategori === kategori) {
                row.style.display = "";
                dataAvailable = true;
            } else {
                row.style.display = "none";
            }
        });
        return dataAvailable;
    });

    document.getElementById('cetak-button').addEventListener('click', function() {
        var kategori = document.getElementById('filter-kategori').options[document.getElementById('filter-kategori').selectedIndex].text;
        var dataAvailable = false;
        var rows = document.querySelectorAll('.aset-row');
        rows.forEach(function(row) {
            var rowKategori = row.getAttribute('data-kategori');
            if (kategori === "Semua" || rowKategori === kategori) {
                dataAvailable = true;
            }
        });
        if (dataAvailable) {
            document.getElementById('cetak-form').submit();
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Data Tidak Tersedia',
                text: 'Tidak ada data yang sesuai dengan filter yang dipilih.'
            });
        }
    });
</script>

@endsection