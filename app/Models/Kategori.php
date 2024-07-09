<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;
    protected $table = 'kategoris';

    protected $fillable = [
        'id', 
        'nama_kategori',
    ];

    public function data_asets()
    {
        return $this->hasMany(Data_aset::class);
    }
}
