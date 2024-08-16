<?php

namespace App\Filament\Widgets;

use App\Models\BarangMasuk;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Carbon;

class BarangMasukChart extends ChartWidget
{
    public ?string $filter = 'month';
    protected static ?int $sort = 6;
    protected static ?string $heading = 'Barang Masuk Chart';

    protected function getFilters(): ?array
    {
        return [
            'today' => 'Today',
            'week' => 'Last week',
            'month' => 'Last month',
            'year' => 'This year',
        ];
    }

    protected function getData(): array
    {
    $activeFilter = $this->filter;
        $data = collect();
        $jumlahData = collect();
        switch ($activeFilter) {
            case 'today':
                $start = now()->startOfDay();
                $end = now()->endOfDay();
                $data = Trend::model(BarangMasuk::class)
                    ->between(start: $start, end: $end)
                    ->perHour()
                    ->count();
                $jumlahData = Trend::model(BarangMasuk::class)
                ->between(start: $start, end: $end)
                ->perHour()
                ->sum('jumlah');
                break;
                
            case 'week':
                $start = now()->startOfWeek();
                $end = now()->endOfWeek();
                $data = Trend::model(BarangMasuk::class)
                    ->between(start: $start, end: $end)
                    ->perDay()
                    ->count();
                    $jumlahData = Trend::model(BarangMasuk::class)
                    ->between(start: $start, end: $end)
                    ->perDay()
                    ->sum('jumlah');
                break;
                
            case 'month':
                $start = now()->startOfMonth();
                $end = now()->endOfMonth();
                $data = Trend::model(BarangMasuk::class)
                    ->between(start: $start, end: $end)
                    ->perDay()
                    ->count();
                    $jumlahData = Trend::model(BarangMasuk::class)
                ->between(start: $start, end: $end)
                ->perDay()
                ->sum('jumlah');
                break;
                
            case 'year':
            default:
                $start = now()->startOfYear();
                $end = now()->endOfYear();
                $data = Trend::model(BarangMasuk::class)
                    ->between(start: $start, end: $end)
                    ->perMonth()
                    ->count();
                    $jumlahData = Trend::model(BarangMasuk::class)
                ->between(start: $start, end: $end)
                ->perMonth()
                ->sum('jumlah');
                break;
        }

        $labels = $data->map(function (TrendValue $value) {
            switch ($this->filter) {
                case 'week':
                    return Carbon::parse($value->date)->format('l'); // Nama hari
                case 'month':
                    return Carbon::parse($value->date)->format('d M'); // Tanggal dan bulan
                case 'year':
                    return Carbon::parse($value->date)->format('M'); // Nama bulan
                case 'today':
                default:
                    return Carbon::parse($value->date)->format('H:i'); // Jam
            }
        });

        return [
            'datasets' => [
                [
                    'label' => 'Barang Masuk',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor' => '#808080',
                    'borderColor' => '#008000',
                    'borderWidth' => 1
                ],
                [
                    'label' => 'Jumlah Stok',
                    'data' => $jumlahData->map(fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#9BD0F5',
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $labels->toArray(),$data->map(fn (TrendValue $value) => $value->date)
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
