@extends('layout.layoutUser')

@section('content')
    
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Daftar Data Aset</h4>
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
                        <a href="aset_user">Data Aset</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Data Aset</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Tambahkan filter pencarian dan status -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <input type="text" id="searchInput" class="form-control" placeholder="Cari Nama Aset...">
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="add-row" class="display table table-striped table-hover" >
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kategori</th>
                                            <th>Nama Aset</th>
                                            <th>Merk</th>
                                            <th>Model</th>
                                            <th>Stok</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no=1 @endphp
                                        @foreach ($data_aset as $row)
                                           <tr class="aset-row" data-status="{{$row->status}}">
                                           <td>{{$no++}}</td>
                                           <td>{{$row->kategori->nama_kategori}}</td>
                                           <td class="nama-aset">{{$row->nama_aset}}</td>
                                           <td>{{$row->merk}}</td>
                                           <td>{{$row->model}}</td>
                                           <td>{{$row->stok}} Pcs </td>
                                           <td>{{$row->status}}</td>
                                           <td>
                                                <a href="#modalView{{$row->id}}" data-toggle="modal" class="btn btn-xs btn-info"><i class="fa fa-eye"></i> View</a>
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

<script>
    document.getElementById('searchInput').addEventListener('keyup', function() {
        var searchValue = this.value.toLowerCase();
        document.querySelectorAll('.aset-row').forEach(function(row) {
            var namaAset = row.querySelector('.nama-aset').textContent.toLowerCase();
            row.style.display = namaAset.includes(searchValue) ? '' : 'none';
        });
    });

    document.getElementById('statusFilter').addEventListener('change', function() {
        var statusValue = this.value;
        document.querySelectorAll('.aset-row').forEach(function(row) {
            var rowStatus = row.getAttribute('data-status');
            if (statusValue === '') {
                row.style.display = '';
            } else if (statusValue === 'Tersedia') {
                row.style.display = (rowStatus === 'Tersedia' || rowStatus === 'Terpakai') ? '' : 'none';
            } else if (statusValue === 'Tidak Tersedia') {
                row.style.display = (rowStatus === 'Rusak' || rowStatus === 'Dipinjam') ? '' : 'none';
            }
        });
    });
</script>

@foreach ($data_aset as $row)
<!-- Modal -->
<div class="modal fade" id="modalView{{$row->id}}" tabindex="-1" role="dialog" aria-labelledby="modalViewLabel{{$row->id}}" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalViewLabel{{$row->id}}">Detail Aset</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <img src="{{ asset('storage/gambar_aset/' . $row->nama_file) }}" alt="Gambar Barang" style="max-width: 100%; height: auto;">
        <p><strong>Kategori:</strong> {{$row->kategori->nama_kategori}}</p>
        <p><strong>Nama Aset:</strong> {{$row->nama_aset}}</p>
        <p><strong>Merk:</strong> {{$row->merk}}</p>
        <p><strong>Model:</strong> {{$row->model}}</p>
        <p><strong>Stok:</strong> {{$row->stok}} Pcs</p>
        <p><strong>Status:</strong> {{$row->status}}</p>
      </div>
    </div>
  </div>
</div>
@endforeach

@endsection
