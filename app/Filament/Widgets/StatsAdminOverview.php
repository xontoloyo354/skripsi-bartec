<?php

namespace App\Filament\Widgets;

use App\Models\BahanBaku;
use App\Models\BarangKeluar;
use App\Models\BarangMasuk;
use App\Models\Golongan;
use App\Models\Jenis;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsAdminOverview extends BaseWidget
{
    protected function getStats(): array
    {
        // Mendapatkan jumlah stok bahan baku yang hampir habis
        $lowStockCount = BahanBaku::where('stock', '<=', 10)->count(); // Misalkan 10 adalah batas stok minimum
        $totalStokMasuk = BarangMasuk::sum('jumlah');

        return [
            Stat::make('Bahan Baku', BahanBaku::query()->count())
            ->description('')
            ->descriptionIcon('heroicon-m-arrow-trending-down')
            ->color('success'),

            Stat::make('Golongan', Golongan::query()->count())
            ->description('')
            ->descriptionIcon('heroicon-m-arrow-trending-down')
            ->color('success'),

            Stat::make('Jenis', Jenis::query()->count())
            ->description('')
            ->descriptionIcon('heroicon-m-arrow-trending-down')
            ->color('success'),
            
            Stat::make('Barang Bahan Baku Masuk', $totalStokMasuk)
                ->description('Barang Baku In')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),

            Stat::make('Barang Bahan Baku Keluar', BarangKeluar::query()->count())
                ->description('Barang Baku Out')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('danger'),

            // Menambahkan statistik stok yang hampir habis
            Stat::make('Stok Hampir Habis', $lowStockCount)
                ->description('Bahan baku dengan stok rendah')
                ->descriptionIcon('heroicon-m-exclamation-circle')
                ->color('danger'),
        ];
    }
}
