<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeBarcodeNullableInDataAsetsTable extends Migration
{
    public function up(): void
    {
        Schema::table('data_asets', function (Blueprint $table) {
            $table->string('barcode')->nullable()->change(); // Mengubah kolom barcode menjadi nullable
        });
    }

    public function down(): void
    {
        Schema::table('data_asets', function (Blueprint $table) {
            $table->string('barcode')->nullable(false)->change(); // Mengembalikan kolom barcode ke nullable false
        });
    }
}

