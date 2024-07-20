@extends('layout.layout')

@section('content')
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Peminjaman Admin</h4>
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
                        <a href="peminjaman-admin">Peminjaman Admin</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Peminjaman Admin</h4>
                                <button class="btn btn-success btn-round ml-auto" data-toggle="modal" data-target="#modalCreate">
                                    <i class="fa fa-plus"></i>
                                    Tambah Data
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="add-row" class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama User</th>
                                            <th>Asal Instansi</th>
                                            <th>Jenis Aset</th>
                                            <th>Tanggal Pinjam</th>
                                            <th>Tanggal Kembali</th>
                                            <th>Status Peminjaman</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no = 1; @endphp
                                        @foreach ($peminjaman as $row)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $row->user->nama }}</td> 
                                            <td>{{ $row->user->asal_instansi }}</td>
                                            <td>{{ $row->data_aset->nama_aset }}</td> 
                                            <td>{{ \Carbon\Carbon::parse($row->tgl_pinjam)->translatedFormat('d M Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($row->tgl_kembali)->translatedFormat('d M Y') }}</td>
                                            <td>
                                                <span class="badge {{ $row->status_peminjaman == 'Pending' ? 'badge-warning' : 'badge-primary' }}">
                                                    {{ $row->status_peminjaman }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group" style="margin-bottom: 10px;">
                                                    <button type="button" class="btn btn-secondary btn-sm btn-action" data-toggle="modal" data-target="#modalDetail{{ $loop->iteration }}">
                                                        <i class="fas fa-info-circle"></i> Detail
                                                    </button>
                                                    <div class="modal fade" id="modalDetail{{ $loop->iteration }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Detail Peminjaman</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <img src="{{ asset('storage/gambar_aset/' . $row->data_aset->nama_file) }}" alt="Gambar Aset" class="img-fluid centered-image">
                                                                    <p>Nama User: {{ $row->user->nama }}</p>
                                                                    <p>Asal Instansi: {{ $row->user->asal_instansi }}</p>
                                                                    <p>Jenis Aset: {{ $row->data_aset->nama_aset }}</p>
                                                                    <p>Merk: {{ $row->data_aset->merk }}</p>
                                                                    <p>Model: {{ $row->data_aset->model }}</p>
                                                                    <p>Tanggal Pinjam: {{ \Carbon\Carbon::parse($row->tgl_pinjam)->translatedFormat('d M Y') }}</p>
                                                                    <p>Tanggal Kembali: {{ \Carbon\Carbon::parse($row->tgl_kembali)->translatedFormat('d M Y') }}</p>
                                                                    <p>Status Peminjaman: {{ $row->status_peminjaman }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <button type="button" class="btn btn-info btn-sm btn-action" data-toggle="modal" data-target="#modalTerima{{ $loop->iteration }}">
                                                        <i class="fa fa-check"></i> Terima
                                                    </button>

                                                    <div class="modal fade" id="modalTerima{{ $loop->iteration }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Terima Peminjaman</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Apakah Anda yakin ingin menerima peminjaman ini?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <form action="{{ route('peminjaman-admin.terima') }}" method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="peminjaman_id" value="{{ $row->id }}">
                                                                        <button type="submit" class="btn btn-primary">Ya</button>
                                                                    </form>
                                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Tidak</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
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


<style>
    .btn-custom {
        width: 60px;
    }

    @media (max-width: 768px) {
        .btn-custom {
            width: 100%;
            margin-bottom: 5px;
        }

    }

    .centered-image {
        display: block;
        margin-left: auto;
        margin-right: auto;
    }

    .badge-warning {
        background-color: rgb(255, 221, 0);
        color: rgb(0, 0, 0);
    }

    .badge-primary {
        background-color: rgb(0, 146, 5);
        color: white;
    }

    .btn-action {
        margin: 0 5px;
    }

</style>

@endsection