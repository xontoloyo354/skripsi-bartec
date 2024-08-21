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
    static::created(function ($barangKeluar) {
        $barangKeluar->updateBahanBakuStock();
        $barangKeluar->sendNotification();
    });

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
    // static::saved(function ($barangKeluar) {
    //     $bahanBaku = $barangKeluar->bahanBaku;
    //     $bahanBaku->stock -= $barangKeluar->jumlah;
    //     $bahanBaku->save();
    // });
    static::updating(function ($barangKeluar) {
        if ($barangKeluar->isDirty('jumlah')) {
            $originalJumlah = $barangKeluar->getOriginal('jumlah');
            $barangKeluar->updateBahanBakuStock($originalJumlah);
            $barangKeluar->sendNotification();
        }
    });  
}
public function updateBahanBakuStock($originalJumlah = 0)
    {
        $bahanBaku = $this->bahanBaku;
        $bahanBaku->stock -= $this->jumlah - $originalJumlah;
        $bahanBaku->save();
    }
    
public function sendNotification()
    {
        $admins = User::where('role', 'admin')->get();
        $kepalaGudang = User::where('role', 'Kepala Gudang')->get();
        Notification::make()
            ->title('Transaksi Barang Keluar')
            ->icon('heroicon-o-plus-circle')
            ->body('Transaksi barang keluar baru telah ditambahkan. Stok bahan baku telah diperbarui.')
            ->sendToDatabase($admins);

            Notification::make()
            ->title('Verifikasi Transaksi Barang Keluar')
            ->icon('heroicon-o-check-circle')
            ->body('Transaksi barang keluar baru telah diajukan. Silakan verifikasi transaksi untuk memastikan keakuratan data.')
            ->sendToDatabase($kepalaGudang);
    }
}

