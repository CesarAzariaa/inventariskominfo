<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Data_aset extends Model
{
    use HasFactory;

    protected $table = 'data_asets';

    protected $fillable = [
        'kategori_id',
        'nama_aset',
        'model',
        'merk',
        'stok',
        'status',
        'tanggal',
        'nama_file',
        'barcode',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class);
    }
}
