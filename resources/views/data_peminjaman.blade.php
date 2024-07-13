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
                    <!-- Form Peminjaman -->
                    <form action="{{ route('data_peminjaman.store') }}" method="POST">
                        @csrf
                        <!-- Informasi Peminjam -->
                        <h2>Informasi Peminjam</h2>
                        <div class="form-group">
                            <label for="nama">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama" name="nama" value="{{ $user->nama }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="asal_instansi">Asal Instansi/Perusahaan</label>
                            <input type="text" class="form-control" id="asal_instansi" name="asal_instansi" value="{{ $user->asal_instansi }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="no_handphone">No Handphone</label>
                            <input type="text" class="form-control" id="no_handphone" name="no_handphone" value="{{ $user->no_handphone }}" readonly>
                        </div>
                    
                        <hr> <!-- Garis Pembatas -->
                    
                        <!-- Informasi Aset -->
                        <h2>Informasi Aset</h2>
                        <div class="form-group">
                            <label for="namaAset">Jenis Aset</label>
                            <select class="form-control" id="namaAset" name="nama_aset" onchange="updateOptions()">
                                <option value="" disabled selected>Pilih Jenis Aset</option>
                                @foreach($grouped_data_asets as $nama_aset => $asets)
                                    <option value="{{ $nama_aset }}">{{ $nama_aset }}</option>
                                @endforeach
                            </select>
                        </div>
                    
                        <div class="form-group">
                            <label for="kategoriAset">Kategori Aset</label>
                            <input type="text" class="form-control" id="kategoriAset" readonly>
                        </div>
                    
                        <div class="form-group">
                            <label for="merk">Merk</label>
                            <select class="form-control" id="merk" name="merk" onchange="updateModelAndStock()" disabled>
                                <option value="" disabled selected>Pilih Merk</option>
                            </select>
                        </div>
                    
                        <div class="form-group">
                            <label for="model">Model</label>
                            <select class="form-control" id="model" name="model" disabled>
                                <option value="" disabled selected>Pilih Model</option>
                            </select>
                        </div>
                    
                        <div class="form-group">
                            <label>Stok</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="stok" name="stok" placeholder="">
                                <div class="input-group-append">
                                    <span class="input-group-text">Pcs</span>
                                </div>
                            </div>
                        </div>
                    
                        <!-- Input hidden untuk data_aset_id -->
                        <input type="hidden" id="data_aset_id" name="data_aset_id">
                    
                        <hr> <!-- Garis Pembatas -->
                    
                        <!-- Detail Peminjaman -->
                        <h2>Detail Peminjaman</h2>
                        <div class="form-group">
                            <label for="tanggalPeminjaman">Tanggal Peminjaman</label>
                            <input type="date" class="form-control" id="tanggalPeminjaman" name="tgl_pinjam">
                        </div>
                        <div class="form-group">
                            <label for="tanggalPengembalian">Tanggal Pengembalian</label>
                            <input type="date" class="form-control" id="tanggalPengembalian" name="tgl_kembali">
                        </div>
                        <div class="form-group">
                            <label for="status_peminjaman">Status Peminjaman</label>
                            <select class="form-control" id="status_peminjaman" name="status_peminjaman">
                                <option value="Pending" selected>Pending</option>
                                <option value="Diterima">Diterima</option>
                            </select>
                        </div>
                        <div class="card-action">
                            <button type="submit" class="btn btn-success" id="submitBtn">Submit</button>
                            <button type="reset" class="btn btn-danger">Cancel</button>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    var jenisAsetSelect = document.getElementById('namaAset');
    var kategoriAsetInput = document.getElementById('kategoriAset');
    var merkSelect = document.getElementById('merk');
    var modelSelect = document.getElementById('model');
    var stokInput = document.getElementById('stok');
    var dataAsetIdInput = document.getElementById('data_aset_id');

    var options = @json($grouped_data_asets);

    function updateOptions() {
        var jenisAset = jenisAsetSelect.value;
        var asets = options[jenisAset];

        kategoriAsetInput.value = asets[0].kategori.nama_kategori;

        merkSelect.innerHTML = '<option value="" disabled selected>Pilih Merk</option>';
        modelSelect.innerHTML = '<option value="" disabled selected>Pilih Model</option>';
        stokInput.value = '';

        asets.forEach(function(aset) {
            var merkOption = document.createElement('option');
            merkOption.value = aset.merk;
            merkOption.textContent = aset.merk;
            merkSelect.appendChild(merkOption);
        });

        merkSelect.disabled = false;
        modelSelect.disabled = true;
    }

    function updateModelAndStock() {
        var jenisAset = jenisAsetSelect.value;
        var merk = merkSelect.value;
        var asets = options[jenisAset].filter(aset => aset.merk === merk);

        modelSelect.innerHTML = '<option value="" disabled selected>Pilih Model</option>';

        asets.forEach(function(aset) {
            var modelOption = document.createElement('option');
            modelOption.value = aset.model;
            modelOption.textContent = aset.model;
            modelSelect.appendChild(modelOption);
        });

        stokInput.value = asets.length > 0 ? asets[0].stok : '';
        modelSelect.disabled = false;
    }

    jenisAsetSelect.addEventListener('change', updateOptions);
    merkSelect.addEventListener('change', updateModelAndStock);

    document.addEventListener('DOMContentLoaded', function() {
        updateOptions();
    });

    document.getElementById('submitBtn').addEventListener('click', function(event) {
        event.preventDefault();
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Pastikan data yang Anda masukkan sudah benar.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, submit!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Set nilai data_aset_id sebelum submit
                var jenisAset = jenisAsetSelect.value;
                dataAsetIdInput.value = options[jenisAset][0].id; // Misalnya ambil ID dari aset pertama

                document.querySelector('form').submit();
            }
        });
    });
</script>

@endsection