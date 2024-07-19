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
        if (Schema::hasTable('bahan_bakus')) return;

        Schema::create('bahan_bakus', function (Blueprint $table) {
            $table->id();
            $table->string('kode_material');
            $table->foreignId('golongan_id')->constrained()->cascadeOnDelete();
            $table->foreignId('jenis_id')->constrained()->cascadeOnDelete();
            $table->string('sub_jenis')
            ->nullable();
            $table->string('material')
            ->nullable();
            $table->string('satuan')
            ->nullable();
            $table->integer('stock')
            ->nullable();
            $table->string('nama_barang')
            ->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bahan_bakus');
    }
};
