@extends('layout.layout')

@section('content')
    
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Data Kategori</h4>
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
                        <a href="#">Data Master</a>
                    </li>
                    <li class="separator">
                        <i class="flaticon-right-arrow"></i>
                    </li>
                    <li class="nav-item">
                        <a href="kategori">Data Kategori</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Data Kategori</h4>
                                <button class="btn btn-success btn-round ml-auto" data-toggle="modal" data-target="#modalCreate">
                                    <i class="fa fa-plus"></i>
                                    Tambah Data
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Modal -->
                            <div class="table-responsive">
                                <table id="add-row" class="display table table-striped table-hover" >
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Kategori</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no=1 @endphp
                                        @foreach ($data_kategori as $row)
                                           <tr>
                                           <td>{{$no++}}</td>
                                           <td>{{$row->nama_kategori}}</td>
                                          <td>
                                            <a href="#modalEdit{{$row->id}}" data-toggle="modal"class="btn btn-xs btn-primary btn-custom"><i class="fa fa-edit"></i>Edit</a>
                                            <a href="#modalHapus{{$row->id}}" data-toggle="modal" class="btn btn-xs btn-danger btn-custom"><i class="fa fa-trash"></i>Hapus</a>
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
                                                <span class="fw-mediumbold">
                                                Tambah</span> 
                                                <span class="fw-mediumbold">
                                                    Kategori
                                                </span>
                                            </h3>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form method="POST" action="/kategori/store" enctype="multipart/form-data">
                                            @csrf
                                        <div class="modal-body">
                                            
                                        <div class="form-group">
                                            <label>Nama Kategori</label>
                                            <input type="text" class="form-control" name="nama_kategori" placeholder="" required>
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

                            @foreach ($data_kategori as $d)

                            <div class="modal fade" id="modalEdit{{ $d->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header no-bd">
                                            <h3 class="modal-title">
                                                <span class="fw-mediumbold">
                                                Edit</span> 
                                                <span class="fw-mediumbold">
                                                    Kategori
                                                </span>
                                            </h3>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form method="POST" action="/kategori/update{{ $d->id }}" enctype="multipart/form-data">
                                            @csrf
                                        <div class="modal-body">
                                            
                                        <div class="form-group">
                                            <label>Nama Kategori</label>
                                            <input type="text" class="form-control" name="nama_kategori" value="{{$d->nama_kategori}}" placeholder="" required>
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

            @foreach ($data_kategori as $d)

                            <div class="modal fade" id="modalHapus{{ $d->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header no-bd">
                                            <h3 class="modal-title">
                                                <span class="fw-mediumbold">
                                                Hapus</span> 
                                                <span class="fw-mediumbold">
                                                    Kategori
                                                </span>
                                            </h3>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form method="GET" action="/kategori/destroy{{ $d->id }}" enctype="multipart/form-data">
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

                            <style>
                                .btn-custom {
                                    width: 60px;
                                }
                            
                                @media (max-width: 768px) {
                                    .btn-custom {
                                        width: 50%; 
                                        margin-bottom: 5px;
                                    }
                                }
                            </style>

@endforeach

@endsection


