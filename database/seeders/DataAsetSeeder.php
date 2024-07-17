<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DataAsetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Data_aset::create([
            'nama_aset' => 'LHG XL 5 ac',
            'kategori_id' => '1',
            'model' => 'RBLHGG-5acD-XL',
            'merk' => 'Mikrotik',
            'stok' => '10',
            'tanggal' => '2024-01-01',
            'nama_file' => 'aset1.jpg',
            'barcode' => '1234567890',
        ]);
    }
}
