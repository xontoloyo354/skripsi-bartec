<?php

namespace App\Models;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    use HasFactory;

    protected $table = 'barang_masuks';

    protected $fillable = [
        'no_surat_masuk',
        'bahan_baku_id',
        'jumlah',
        'status',
        'no_surat_jalan',
        'pembawa',
        'kendaraan',
        'posisi',
        'no_plat',
        'lokasi',
        'kepada',
    ];

    protected static function booted()
{
    static::saved(function ($barangMasuk) {
        $bahanBaku = $barangMasuk->bahanBaku;
        $bahanBaku->stock += $barangMasuk->jumlah;
        $bahanBaku->save();
    });
    static::created(function ($barangMasuk) {
        $barangMasuk->updateBahanBakuStock();
        $barangMasuk->sendNotification();
    });

    // Triggered when a record is updated
    static::updating(function ($barangMasuk) {
        if ($barangMasuk->isDirty('jumlah')) {
            $originalJumlah = $barangMasuk->getOriginal('jumlah');
            $barangMasuk->updateBahanBakuStock($originalJumlah);
            $barangMasuk->sendNotification();
        }
    });
}

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
        return 'BB/IN' . str_pad($number, 5, '0', STR_PAD_LEFT);
    }

    public function bahanBaku()
    {
        return $this->belongsTo(BahanBaku::class);
    }
    public function updateBahanBakuStock($originalJumlah = 0)
    {
        $bahanBaku = $this->bahanBaku;
        $bahanBaku->stock += $this->jumlah - $originalJumlah;
        $bahanBaku->save();
    }
    
    public function sendNotification()
    {
        $admins = User::where('role', 'admin')->get();
        $kepalaGudang = User::where('role', 'Kepala Gudang')->get();
        Notification::make()
            ->title('Transaksi Barang Masuk')
            ->icon('heroicon-o-plus-circle')
            ->body('Transaksi barang masuk baru telah ditambahkan. Stok bahan baku telah diperbarui.')
            ->sendToDatabase($admins);

            Notification::make()
            ->title('Verifikasi Transaksi Barang Masuk')
            ->icon('heroicon-o-check-circle')
            ->body('Transaksi barang masuk baru telah ditambahkan. Silakan verifikasi transaksi untuk memastikan keakuratan data.')
            ->sendToDatabase($kepalaGudang);
    }
}
