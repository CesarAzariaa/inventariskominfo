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
                                <div class="ml-auto">
                                    <form id="cetak-form" action="{{ route('qr-code-pdf') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="selected_ids" id="selected-ids">
                                        <button type="button" id="cetak-button" class="btn btn-danger">
                                            <i class="fa fa-file"></i> Cetak PDF
                                        </button>
                                    </form>
                                </div>
                            </div>
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
                                            <th>Model</th>
                                            <th>Stok</th>
                                            <th>Status</th>
                                            <th>QR Code</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no=1 @endphp
                                        @foreach ($data_aset as $row)
                                            <tr>
                                                <td><input type="checkbox" class="row-checkbox" name="aset_ids[]" value="{{ $row->id }}"></td>
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
    document.getElementById('select-all-checkbox').addEventListener('change', function() {
        var isChecked = this.checked;
        var checkboxes = document.querySelectorAll('.row-checkbox');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = isChecked;
        });
    });

    document.getElementById('cetak-button').addEventListener('click', function() {
        var selectedCheckboxes = document.querySelectorAll('.row-checkbox:checked');
        if (selectedCheckboxes.length > 0) {
            var selectedIds = [];
            selectedCheckboxes.forEach(function(checkbox) {
                selectedIds.push(checkbox.value);
            });
            document.getElementById('selected-ids').value = selectedIds.join(',');
            document.getElementById('cetak-form').submit();
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Tidak Ada Data Terpilih',
                text: 'Silakan pilih setidaknya satu data untuk dicetak.'
            });
        }
    });
</script>

@endsection
