<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('data_asets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_id')->constrained();
            $table->string('nama_aset');
            $table->string('model');
            $table->string('merk');
            $table->string('serial_number');
            $table->integer('stok');
            $table->string('status');
            $table->date('tanggal');
            $table->string('nama_file')->nullable();
            $table->string('barcode');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_asets');
    }
};
