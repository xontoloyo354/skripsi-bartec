<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangKeluar extends Model
{
    use HasFactory;

    protected $fillable = [
       'no_surat_keluar',
       'bahan_baku_id',
       'jumlah',
       'keperluan',
       'acuan',
       'no_acuan',
       'penerima',
       'pengambil',
       'jabatan',
       'security',
       'kendaraan',
       'no_plat',
    ];

    public function bahanBaku()
    {
        return $this->belongsTo(BahanBaku::class);
    }

    protected static function booted()
{
    static::saved(function ($barangKeluar) {
        $bahanBaku = $barangKeluar->bahanBaku;
        $bahanBaku->stock -= $barangKeluar->jumlah;
        $bahanBaku->save();
    });
}

    
}

