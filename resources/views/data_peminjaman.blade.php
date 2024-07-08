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
                    <form action="{{ route('peminjaman.store') }}" method="POST">
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
                            <select class="form-control" id="namaAset" name="data_aset_id" onchange="updateOptions()">
                                <option value="" disabled selected>Pilih Jenis Aset</option>
                                @php
                                    $uniqueAses = [];
                                @endphp
                                @foreach($data_asets as $aset)
                                    @if (!isset($uniqueAses[$aset->nama_aset]))
                                        @php
                                            $uniqueAses[$aset->nama_aset] = true;
                                        @endphp
                                        <option value="{{ $aset->id }}" data-merk="{{ $aset->merk }}" data-model="{{ $aset->model }}" data-kategori="{{ $aset->kategori->nama_kategori }}" data-stok="{{ $aset->stok }}">{{ $aset->nama_aset }}</option>
                                    @endif
                                @endforeach
                            </select>                                                       
                        </div>
                        
                        <div class="form-group">
                            <label for="kategoriAset">Kategori Aset</label>
                            <input type="text" class="form-control" id="kategoriAset" readonly>
                        </div>

                        <div class="form-group">
                            <label for="merk">Merk</label>
                            <select class="form-control" id="merk" name="merk" disabled>
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
                                <input type="number" class="form-control" id="stok" name="stok" placeholder="" required>
                                <div class="input-group-append">
                                    <span class="input-group-text">Pcs</span>
                                </div>
                            </div>
                        </div>

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
                        <div class="card-action">
                            <button type="submit" class="btn btn-success">Submit</button>
                            <button type="reset" class="btn btn-danger">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Ambil elemen select jenis aset
    var jenisAsetSelect = document.getElementById('namaAset');
    // Ambil elemen input kategori aset
    var kategoriAsetInput = document.getElementById('kategoriAset');
    // Ambil elemen select merk
    var merkSelect = document.getElementById('merk');
    // Ambil elemen select model
    var modelSelect = document.getElementById('model');
    // Ambil elemen input stok
    var stokInput = document.getElementById('stok');

    // Daftar opsi merk, model, kategori, dan stok untuk setiap jenis aset
    var options = {
        @foreach($data_asets as $aset)
            '{{ $aset->id }}': {
                merk: '{{ $aset->merk }}',
                model: '{{ $aset->model }}',
                kategori: '{{ $aset->kategori->nama_kategori }}',
                stok: '{{ $aset->stok }}'
            },
        @endforeach
    };

    // Fungsi untuk memperbarui pilihan kategori, merk, model, dan stok berdasarkan jenis aset yang dipilih
    // Fungsi untuk memperbarui pilihan kategori, merk, model, dan stok berdasarkan jenis aset yang dipilih
    function updateOptions() {
    var jenisAsetId = jenisAsetSelect.value;
    var selectedOptions = options[jenisAsetId];

    // Update nilai kategori aset
    kategoriAsetInput.value = selectedOptions.kategori;

    // Kosongkan opsi merk terlebih dahulu
    merkSelect.innerHTML = '';
    // Tambahkan opsi default
    var defaultMerkOption = document.createElement('option');
    defaultMerkOption.textContent = 'Pilih Merk Aset';
    merkSelect.appendChild(defaultMerkOption);

    // Tambahkan opsi merk berdasarkan jenis aset yang dipilih
    var merkOption = document.createElement('option');
    merkOption.textContent = selectedOptions.merk;
    merkOption.value = selectedOptions.merk;
    merkSelect.appendChild(merkOption);

    // Kosongkan opsi model terlebih dahulu
    modelSelect.innerHTML = '';
    // Tambahkan opsi default
    var defaultModelOption = document.createElement('option');
    defaultModelOption.textContent = 'Pilih Model Aset';
    modelSelect.appendChild(defaultModelOption);

    // Tambahkan opsi model berdasarkan jenis aset yang dipilih
    var modelOption = document.createElement('option');
    modelOption.textContent = selectedOptions.model;
    modelOption.value = selectedOptions.model;
    modelSelect.appendChild(modelOption);

    // Update nilai stok dan aktifkan input
    stokInput.value = selectedOptions.stok;
    stokInput.removeAttribute('readonly'); // Menghapus atribut readonly

    // Aktifkan kembali dropdown merk dan model
    merkSelect.disabled = false;
    modelSelect.disabled = false;
}

// Panggil fungsi updateOptions() saat jenis aset dipilih
jenisAsetSelect.addEventListener('change', updateOptions);

// Panggil fungsi updateOptions() untuk memuat opsi merk, model, dan stok awal saat halaman dimuat
updateOptions();

</script>

@endsection
