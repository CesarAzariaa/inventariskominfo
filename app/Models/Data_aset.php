<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Data_Aset extends Model
{
    use HasFactory;

    protected $table = 'data_asets';

    protected $fillable = [
        'kategori_id',
        'nama_aset',
        'model',
        'merk',
        'serial_number',
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
}
