<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Data_aset;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjamans';

    protected $fillable = [
        'user_id',
        'data_aset_id',
        'tgl_pinjam',
        'tgl_kembali',
        'status_peminjaman',
    ];
    
    public function users()
    {
        return $this->belongsTo(User::class);
    }
    public function data_asets()
    {
        return $this->belongsTo(Data_aset::class);
    }
    
    public function getKategoriIdAttribute()
    {
        return $this->data_aset->kategori_id;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function data_aset()
    {
        return $this->belongsTo(Data_aset::class, 'data_aset_id');
    }

}