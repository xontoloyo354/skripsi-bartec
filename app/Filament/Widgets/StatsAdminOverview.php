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
    protected static ?string $pollingInterval = '5s';
    protected static bool $isLazy = false;
    
    protected function getStats(): array
    {
        $stokMasukPerBarang = BarangMasuk::with('bahanBaku')
            ->orderBy('jumlah', 'desc')
            ->take(10)
            ->get() // Batasi jumlah barang yang diambil untuk chart (opsional)
            ->pluck('jumlah', 'bahanBaku.nama_barang')
            ->toArray();
        $totalStokMasuk = BarangMasuk::sum('jumlah');
        ;

        $lowStockItems = BahanBaku::where('stock', '<=', 10)->with(['golongan', 'jenis'])->get(); // Misalkan 10 adalah batas stok minimum
        $lowStockDescriptions = $lowStockItems->take(3)->map(function ($item) {
            return "{$item->golongan->name} {$item->jenis->name} stok rendah";
                })->implode(', ');
        $lowStockCount = $lowStockItems->count();
        $hiddenItemsCount = max(0, $lowStockCount - 3);
        if ($hiddenItemsCount > 0) {
            $lowStockDescriptions .= ' dan ' . $hiddenItemsCount . ' item lainnya';
        }
       

                

        return [
            Stat::make('Bahan Baku', BahanBaku::query()->count())
            ->description('Total Bahan Baku')
            ->descriptionIcon('heroicon-m-archive-box')
            ->color('success'),

            Stat::make('Golongan', Golongan::query()->count())
            ->description('Total Golongan')
            ->descriptionIcon('heroicon-m-arrow-trending-down')
            ->color('success'),

            Stat::make('Jenis', Jenis::query()->count())
            ->description('Total Jenis')
            ->descriptionIcon('heroicon-m-arrow-trending-down')
            ->color('success'),
            
            Stat::make('Barang Bahan Baku Masuk', $totalStokMasuk)
                ->description('Total Stok Barang Baku In')
                ->descriptionIcon('heroicon-m-archive-box-arrow-down')
                ->chart(array_values($stokMasukPerBarang))
                ->color('success'),

            Stat::make('Barang Bahan Baku Keluar', BarangKeluar::query()->count())
                ->description('Barang Baku Out')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('danger'),

            // Menambahkan statistik stok yang hampir habis
            Stat::make('Stok Hampir Habis', $lowStockCount)
                ->description($lowStockDescriptions)
                ->descriptionIcon('heroicon-m-exclamation-circle')
                ->color('danger'),
        ];
    }
}
