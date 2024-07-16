<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_surat_masuk',
        'bahan_baku_id',
        'jumlah',
        'no_surat_jalan',
        'pembawa',
        'kendaraan',
        'posisi',
        'no_plat',
    ];

    protected static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->no_surat_masuk = self::generateNoSuratMasuk();
        });
    }

    public static function generateNoSuratMasuk()
    {
        $latestRecord = self::latest()->first();
        $number = $latestRecord ? intval(substr($latestRecord->no_surat_masuk, -5)) + 1 : 1;
        return 'NSM-' . str_pad($number, 5, '0', STR_PAD_LEFT);
    }

    public function bahanBaku()
    {
        return $this->belongsTo(BahanBaku::class);
    }
}
