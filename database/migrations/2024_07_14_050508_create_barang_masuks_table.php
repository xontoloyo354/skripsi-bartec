<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('barang_masuks', function (Blueprint $table) {
            $table->id();
            $table->string('no_surat_masuk');
            $table->foreignId('bahan_baku_id');
            $table->integer('jumlah');
            $table->string('no_surat_jalan');
            $table->string('pembawa');
            $table->string('kendaraan');
            $table->string('posisi');
            $table->string('no_plat');
            $table->string('lokasi');
            $table->string('kepada');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_masuks');
    }
};
