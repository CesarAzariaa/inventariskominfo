@extends('layout.layoutUser')

@section('content')
    
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Daftar Peminjaman Aset</h4>
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
                        <a href="aset_user">Peminjaman Aset</a>
                    </li>
                </ul>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Form Peminjaman Aset</div>
                </div>
                <div class="card-body">
                    <!-- Informasi Peminjam -->
                    <h2>Informasi Peminjam</h2>
                    <div class="form-group">
                        <label for="namaPeminjam">Nama Lengkap</label>
                        <input type="text" class="form-control input-square" id="namaPeminjam" placeholder="Ketik Nama Anda..">
                    </div>
                    <div class="form-group">
                        <label for="instansi">Asal Instansi/Perusahaan</label>
                        <input type="text" class="form-control input-square" id="instansi" placeholder="Ketik Asal Instansi Anda..">
                    </div>
                    <div class="form-group">
                        <label for="no_hp">No Handphone</label>
                        <input type="text" class="form-control input-pill" id="no_hp" placeholder="Masukkan No Handphone Anda">
                    </div>
    
                    <hr> <!-- Garis Pembatas -->

                    <!-- Informasi Aset -->
                    <h2>Informasi Aset</h2>
                    <div class="form-group">
                        <label for="squareSelect">Pilih Kategori</label>
                        <select class="form-control input-square" id="squareSelect">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="merk">Merk</label>
                        <input type="text" class="form-control input-square" id="merk" placeholder="Ketik Nama Aset..">
                    </div>

                    <div class="form-group">
                        <label for="squareSelect">Nama Aset</label>
                        <select class="form-control input-square" id="squareSelect">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Stok</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="stok" placeholder="" required>
                            <div class="input-group-append">
                                <span class="input-group-text">Pcs</span>
                            </div>
                        </div>
                    </div
                </div>
            
                    <hr> <!-- Garis Pembatas -->

                    <!-- Detail Peminjaman -->
                    <h2>Detail Peminjaman</h2>
                    <div class="form-group">
                        <label for="tanggalPeminjaman">Tanggal Peminjaman</label>
                        <input type="date" class="form-control input-square" id="tanggalPeminjaman">
                    </div>
                    <div class="form-group">
                        <label for="tanggalPengembalian">Tanggal Pengembalian</label>
                        <input type="date" class="form-control input-square" id="tanggalPengembalian">
                    </div>									
                </div>
                <div class="card-action">
                    <button class="btn btn-success">Submit</button>
                    <button class="btn btn-danger">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
