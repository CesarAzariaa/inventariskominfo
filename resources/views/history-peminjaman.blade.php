@extends('layout.layoutUser')

@section('content')
    
<div class="main-panel">
    <div class="content">
        <div class="page-inner">

            <div class="page-header">
                <h4 class="page-title">Riwayat Peminjaman Aset</h4>

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
                        <a href="history_peminjaman">Riwayat Peminjaman</a>
                    </li>

                </ul>
            </div>
            <div class="row">

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Riwayat Peminjaman Aset</h4>
                            </div>

                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                @if($riwayat_peminjaman->isEmpty())
                                    <p style="text-align: center;">Anda belum meminjam barang.</p>
                                @else
                                <table id="add-row" class="display table table-striped table-hover" >
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Aset</th>
                                            <th>Merk</th>
                                            <th>Model</th>
                                            <th>Stok</th>
                                            <th>Tanggal Peminjaman</th>
                                            <th>Tanggal Pengembalian</th>
                                            <th>Status</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no=1 @endphp
                                        @foreach ($riwayat_peminjaman as $peminjaman)
                                           <tr>
                                           <td>{{$no++}}</td>
                                           <td>{{$peminjaman->data_aset->nama_aset}}</td>
                                           <td>{{$peminjaman->data_aset->merk}}</td>
                                           <td>{{$peminjaman->data_aset->model}}</td>
                                           <td>{{$peminjaman->data_aset->stok}}</td>
                                           <td>{{ \Carbon\Carbon::parse($peminjaman->tgl_pinjam)->translatedFormat('d M Y') }}</td>
                                           <td>{{ \Carbon\Carbon::parse($peminjaman->tgl_kembali)->translatedFormat('d M Y') }}</td>
                                           <td>
                                               <span class="badge {{ $peminjaman->status_peminjaman == 'Pending' ? 'badge-warning' : 'badge-primary' }}">
                                                   {{ $peminjaman->status_peminjaman }}
                                               </span>
                                           </td>
                                        </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .badge-warning {
        background-color: rgb(255, 221, 0);
        color: rgb(0, 0, 0);
    }

    .badge-primary {
        background-color: rgb(0, 146, 5);
        color: white;
    }
</style>
@endsection