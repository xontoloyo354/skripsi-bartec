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
        Schema::create('barang_keluars', function (Blueprint $table) {
            $table->id();
            $table->string('no_surat_keluar');
            $table->foreignId('bahan_baku_id');
            $table->integer('jumlah');
            $table->string('keperluan');
            $table->string('acuan');
            $table->integer('no_acuan');
            $table->string('penerima');
            $table->string('pengambil');
            $table->string('jabatan');
            $table->string('security');
            $table->string('kendaraan');
            $table->string('no_plat');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_keluars');
    }
};
