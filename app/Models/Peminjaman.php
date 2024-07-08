<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class peminjaman extends Model
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
        return $this->hasMany(User::class);
    }
    public function data_asets()
    {
        return $this->hasMany(Data_aset::class);
    }

}
