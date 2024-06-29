@extends('layout.layout')

@section('content')
    
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Data Aset Keluar</h4>
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
                        <a href="aset_keluar">Data Aset Keluar</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Data Aset Keluar</h4>
                                <button class="btn btn-success btn-round ml-auto" data-toggle="modal" data-target="#modalCreate">
                                    <i class="fa fa-plus"></i>
                                    Tambah Data
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="add-row" class="display table table-striped table-hover" >
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Aset</th>
                                            <th>Kategori</th>
                                            <th>Merk</th>
                                            <th>Model</th>
                                            <th>Stok</th>
                                            <th>Status</th>
                                            <th>Tanggal Keluar</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no=1 @endphp
                                        @foreach ($data_aset as $row)
                                           @if ($row->status == 'Rusak' || $row->status == 'Dipinjam')
                                           <tr>
                                               <td>{{$no++}}</td>
                                               <td>{{$row->nama_aset}}</td>
                                               <td>{{$row->kategori->nama_kategori}}</td>
                                               <td>{{$row->merk}}</td>
                                               <td>{{$row->model}}</td>
                                               <td>{{$row->stok}} Pcs </td>
                                               <td>{{$row->status}}</td>
                                               <td>{{$row->tanggal}}</td>
                                               <td>
                                                <a href="#modalView{{$row->id}}" data-toggle="modal" class="btn btn-xs btn-info btn-custom"><i class="fa fa-eye"></i> View</a>
                                                <a href="#modalEdit{{$row->id}}" data-toggle="modal" class="btn btn-xs btn-primary btn-custom"><i class="fa fa-edit"></i> Edit</a>
                                                <a href="#modalHapus{{$row->id}}" data-toggle="modal" class="btn btn-xs btn-danger btn-custom"><i class="fa fa-trash"></i> Hapus</a>
                                            </td>
                                           </tr>
                                           <!-- Modal View -->
                                           <div class="modal fade" id="modalView{{$row->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog custom-modal" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header no-bd">
                                                        <h3 class="modal-title">
                                                            <span class="fw-mediumbold">Detail</span> 
                                                            <span class="fw-mediumbold">Barang</span>
                                                        </h3>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div style="display: flex; justify-content: center;">
                                                            <img src="{{ asset('storage/gambar_aset/' . $row->nama_file) }}" alt="Gambar Barang" style="max-width: 100%; height: auto;">
                                                        </div>                                                            
                                                            <label>Nama Aset</label>
                                                            <input type="text" class="form-control" value="{{$row->nama_aset}}" readonly>
                                                        </div>
                                        
                                                        <div class="form-group">
                                                            <label>Kategori</label>
                                                            <input type="text" class="form-control" value="{{$row->nama_kategori}}" readonly>
                                                        </div>
                                        
                                                        <div class="form-group">
                                                            <label>Model</label>
                                                            <input type="text" class="form-control" value="{{$row->model}}" readonly>
                                                        </div>
                                        
                                                        <div class="form-group">
                                                            <label>Merk</label>
                                                            <input type="text" class="form-control" value="{{$row->merk}}" readonly>
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Stok</label>
                                                            <input type="text" class="form-control" value="{{$row->stok}} Pcs" readonly>
                                                        </div>
                                        
                                                        <div class="form-group">
                                                            <label>Status</label>
                                                            <input type="text" class="form-control" value="{{$row->status}}" readonly>
                                                        </div>
                                        
                                                        <div class="form-group">
                                                            <label>Tanggal</label>
                                                            <input type="text" class="form-control" value="{{$row->tanggal}}" readonly>
                                                        </div>
                                        
                                                        <div class="form-group">
                                                            <label>QR Code</label><br>
                                                            @if ($row->barcode)
                                                                <img src="{{ asset('storage/' . $row->barcode) }}" alt="QR Code" style="width: 125px; height: 125px;">
                                                            @else
                                                            <p>QR Code tidak tersedia.</p>
                                                        @endif
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        @endif
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
<div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header no-bd">
            <h3 class="modal-title">
                <span class="fw-mediumbold">Tambah</span> 
                <span class="fw-mediumbold">Barang</span>
            </h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form method="POST" action="/aset/store" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Aset</label>
                    <input type="text" class="form-control" name="nama_aset" placeholder="" required>
                </div>

                <div class="form-group">
                    <label>Nama Kategori</label>
                    <select class="form-control" name="kategori_id" required>
                        <option value="" hidden> Pilih Kategori </option>
                        @foreach ($data_kategori as $z)
                        <option value="{{ $z->id }}">{{ $z->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Model</label>
                    <input type="text" class="form-control" name="model" placeholder="" required>
                </div>

                <div class="form-group">
                    <label>Merk</label>
                    <input type="text" class="form-control" name="merk" placeholder="" required>
                </div>

                <div class="form-group">
                    <label>Stok</label>
                    <div class="input-group">
                        <input type="number" class="form-control" name="stok" placeholder="" required>
                        <div class="input-group-append">
                            <span class="input-group-text">Pcs</span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" name="status" required>
                        <option value="">Pilih Status</option>
                        <option value="Tersedia">Tersedia</option>
                        <option value="Terpakai">Terpakai</option>
                        <option value="Rusak">Rusak</option>
                        <option value="Dipinjam">Dipinjam</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Tanggal</label>
                    <input type="date" class="form-control" name="tanggal" placeholder="" required>
                </div>

                <div class="form-group">
                    <label>Gambar</label>
                    <input type="file" class="form-control-file" name="nama_file" accept="image/*">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary"><i></i>Simpan Perubahan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i></i>Batal</button>
            </div>
        </form>
    </div>
</div>
</div>


@foreach ($data_aset as $d)
<!-- Modal Edit -->
<div class="modal fade" id="modalEdit{{$d->id}}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header no-bd">
                <h3 class="modal-title">
                    <span class="fw-mediumbold">Edit</span> 
                    <span class="fw-mediumbold">Barang</span>
                </h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/aset/update/{{$d->id}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Aset</label>
                        <input type="text" class="form-control" value="{{$d->nama_aset}}" name="nama_aset" placeholder="" required>
                    </div>

                    <div class="form-group">
                        <label>Nama Kategori</label>
                        <select class="form-control" name="kategori_id" required>
                            <!-- Tampilkan semua kategori dan tandai yang sebelumnya dipilih -->
                            @foreach ($data_kategori as $x)
                                <option value="{{ $x->id }}" {{ $d->id_kategori == $x->id ? 'selected' : '' }}>{{ $x->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Model</label>
                        <input type="text" class="form-control" value="{{$d->model}}" name="model" placeholder="" required>
                    </div>

                    <div class="form-group">
                        <label>Merk</label>
                        <input type="text" class="form-control" value="{{$d->merk}}" name="merk" placeholder="" required>
                    </div>
                        
                    <div class="form-group">
                        <label>Stok</label>
                        <div class="input-group">
                            <input type="number" class="form-control" value="{{$d->stok}}" name="stok" placeholder="" required>
                            <div class="input-group-append">
                                <span class="input-group-text">Pcs</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control" name="status" required>
                            <option value="{{$d->status}}" selected>{{$d->status}}</option>
                            <option value="Tersedia">Tersedia</option>
                            <option value="Terpakai">Terpakai</option>
                            <option value="Rusak">Rusak</option>
                            <option value="Dipinjam">Dipinjam</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Tanggal</label>
                        <input type="date" class="form-control" value="{{$d->tanggal}}" name="tanggal" placeholder="" required>
                    </div>

                    <div class="form-group">
                        @if ($d->nama_file)
                           <img src="{{ asset('storage/gambar_aset/' . $d->nama_file) }}" alt="Gambar Barang" style="max-width: 100%; height: auto;">
                        @endif
                        <input type="file" class="form-control-file" name="nama_file" accept="image/*">
                        <small class="form-text text-muted">Pilih gambar untuk aset jika ingin mengganti gambar yang sudah ada.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><i></i>Simpan Perubahan</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i></i>Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal Hapus -->
<div class="modal fade" id="modalHapus{{$d->id}}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header no-bd">
                <h3 class="modal-title">
                    <span class="fw-mediumbold">Hapus</span> 
                    <span class="fw-mediumbold">Barang</span>
                </h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('aset.destroy', ['id' => $d->id]) }}">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <div class="form-group">
                        <h4 style="text-align: center;">Apakah Anda Ingin Menghapus Data Ini?</h4>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger"><i></i>Hapus</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i></i>Close</button>
                </div>
            </form>
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
</style>

@endforeach

@endsection