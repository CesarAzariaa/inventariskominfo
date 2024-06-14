<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{

    public function run(): void
    {
        User::create([
            'nama' => 'Cesar Azaria',
            'username' => 'admin',
            'no_handphone' => '081234567891',
            'asal_instansi' => 'Diskominfotik Bengkalis',
            'password' => Hash::make('admin'),
            'role' => 'admin',
        ]);
    }
}
