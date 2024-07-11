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
                                            <td>{{ $row->data_aset->nama_aset }}</td> 
                                            <td>{{ $row->tgl_pinjam }}</td>
                                            <td>{{ $row->tgl_kembali }}</td>
                                            <td>{{ $row->status_peminjaman }}</td>
                                            <td>
                                            <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#modalDetail{{ $loop->iteration }}">
                                                Detail
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
                                                            <p>Jenis Aset: {{ $row->data_aset->nama_aset }}</p>
                                                            <p>Merk: {{ $row->data_aset->merk }}</p>
                                                            <p>Model: {{ $row->data_aset->model }}</p>
                                                            <p>Tanggal Pinjam: {{ $row->tgl_pinjam }}</p>
                                                            <p>Tanggal Kembali: {{ $row->tgl_kembali }}</p>
                                                            <p>Status Peminjaman: {{ $row->status_peminjaman }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalTerima{{ $loop->iteration }}">
                                                Terima
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
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                                                            <form action="{{ route('peminjaman-admin.update', ['id' => $row->id]) }}" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="status_peminjaman" value="diterima">
                                                                <button type="submit" class="btn btn-primary">Ya</button>
                                                            </form>
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
</style>
@endsection