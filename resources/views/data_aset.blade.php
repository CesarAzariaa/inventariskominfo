@extends('layout.layout')

@section('content')
    
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Data Aset</h4>
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
                        <a href="data_aset">Data Aset</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Data Aset</h4>
                                <button class="btn btn-primary btn-round ml-auto" data-toggle="modal" data-target="#modalCreate">
                                    <i class="fa fa-plus"></i>
                                    Tambah Data
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Modal -->
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
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no=1 @endphp
                                        @foreach ($data_aset as $row)
                                            <tr>
                                                <td>{{$no++}}</td>
                                                <td>{{$row->nama_aset}}</td>
                                                <td>{{$row->nama_kategori}}</td>
                                                <td>{{$row->merk}}</td>
                                                <td>{{$row->stok}} Pcs</td>
                                                <td>{{$row->status}}</td>
                                                <td>{{$row->tanggal}}</td>
                                                <td>
                                                    <a href="#modalView{{$row->id}}" data-toggle="modal" class="btn btn-xs btn-info"><i class="fa fa-eye"></i>View</a>
                                                    <a href="#modalEdit{{$row->id}}" data-toggle="modal" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i> Edit</a>
                                                    <a href="#modalHapus{{$row->id}}" data-toggle="modal" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Hapus</a>
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
                        <label>S/N</label>
                        <input type="text" class="form-control" name="serial_number" placeholder="" required>
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
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><i></i>Save Changes</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i></i>Undo</button>
                </div>
            </form>
        </div>
    </div>
</div>

                            @foreach ($data_aset as $d)

                            <div class="modal fade" id="modalEdit{{ $d->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header no-bd">
                                            <h3 class="modal-title">
                                                <span class="fw-mediumbold">
                                                Edit</span> 
                                                <span class="fw-mediumbold">
                                                    Barang
                                                </span>
                                            </h3>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form method="POST" action="/aset/update{{ $d->id }}" enctype="multipart/form-data">
                                            @csrf
                                        <div class="modal-body">
                                            
                                            <div class="form-group">
                                                <label>Nama Aset</label>
                                                <input type="text" class="form-control" value="{{ $d->nama_aset }}" name="nama_aset" placeholder="" required>
                                            </div>
    
                                            <div class="form-group">
                                                <label>Nama Kategori</label>
                                                <select class="form-control" name="id.kategori" required>
                                                <option value="{{ $d->id_kategori }}">{{ $d->nama_kategori }}</option>
                                                @foreach ($data_kategori as $x)
                                                <option value="{{ $x->id }}">{{ $x->nama_kategori }}</option>
                                                @endforeach
                                                </select>
                                            </div>
    
                                            <div class="form-group">
                                                <label>Model</label>
                                                <input type="text" class="form-control" value="{{ $d->model }}" name="model" placeholder="" required>
                                            </div>
    
                                            <div class="form-group">
                                                <label>Merk</label>
                                                <input type="text" class="form-control" value="{{ $d->merk }}" name="merk" placeholder="" required>
                                            </div>

                                            <div class="form-group">
                                                <label>S/N</label>
                                                <input type="text" class="form-control" value="{{ $d->serial_number }}" name="serial_number" placeholder="" required>
                                            </div>
    
                                            <div class="form-group">
                                                <label>Stok</label>
                                                <div class="input-group">
                                                    <input type="number" class="form-control" value="{{ $d->stok }}" name="stok" placeholder="" required>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">Pcs</span>
                                                    </div>
                                                </div>
                                            </div>
    
                                            <div class="form-group">
                                                <label>Status</label>
                                                <select class="form-control" value="{{ $d->status }}" name="status" required>
                                                    <option value="">Pilih Status</option>
                                                    <option value="Tersedia">Tersedia</option>
                                                    <option value="Terpakai">Terpakai</option>
                                                    <option value="Rusak">Rusak</option>
                                                    <option value="Dipinjam">Dipinjam</option>
                                                </select>
                                            </div>
    
                                            <div class="form-group">
                                                <label>Tanggal</label>
                                                <input type="date" class="form-control" value="{{ $d->tanggal }}" name="tanggal" placeholder="" required>
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary"><i></i>Save Changes</button>
                                            <button type="button" class="btn btn-danger" data-dismiss="modal"><i></i>Undo</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
            @endforeach

            @foreach ($data_aset as $d)

                            <div class="modal fade" id="modalHapus{{ $d->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header no-bd">
                                            <h3 class="modal-title">
                                                <span class="fw-mediumbold">
                                                Hapus</span> 
                                                <span class="fw-mediumbold">
                                                    Barang
                                                </span>
                                            </h3>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form method="GET" action="/aset/destroy{{ $d->id }}" enctype="multipart/form-data">
                                            @csrf
                                        <div class="modal-body">
                                            
                                        <div class="form-group">
                                            <h4 style="text-align: center;">Apakah Anda Ingin Mengapus Data Ini?</h4>
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
@endforeach

@endsection


