<?php

namespace App\Models;

use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangKeluar extends Model
{
    use HasFactory;

    protected $table = 'barang_keluars';

    protected $fillable = [
       'no_surat_keluar',
       'bahan_baku_id',
       'jumlah',
       'keperluan',
       'status',
       'acuan',
       'no_acuan',
       'penerima',
       'pengambil',
       'jabatan',
       'security',
       'kendaraan',
       'no_plat',
       'tujuan',
    ];

    public function bahanBaku()
    {
        return $this->belongsTo(BahanBaku::class);
    }

    protected static function booted()
{

    static::saving(function ($barangKeluar) {
        $bahanBaku = $barangKeluar->bahanBaku;
        
        if ($bahanBaku->stock < $barangKeluar->jumlah) {
            Notification::make()
                ->title('Stok Habis')
                ->body('Stok bahan baku tidak mencukupi untuk jumlah barang yang ingin dikeluarkan.')
                ->danger()
                ->send();
            
            return false; // Menghentikan proses penyimpanan data
        }
    });
    static::saved(function ($barangKeluar) {
        $bahanBaku = $barangKeluar->bahanBaku;
        $bahanBaku->stock -= $barangKeluar->jumlah;
        $bahanBaku->save();
    });
}
}

