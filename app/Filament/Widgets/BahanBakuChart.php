<?php

namespace App\Filament\Widgets;

use App\Models\BahanBaku;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;

class BahanBakuChart extends ChartWidget
{
    public ?string $filter = 'month'; // Set default filter
    public static ?string $heading = 'Bahan Baku Chart';
    protected static ?int $sort = 7;


    protected function getData(): array
    {
        $activeFilter = $this->filter;

        // Menentukan rentang waktu berdasarkan filter yang aktif
        switch ($activeFilter) {
            case 'week':
                $start = now()->startOfWeek();
                $end = now()->endOfWeek();
                break;
            case 'month':
                $start = now()->startOfMonth();
                $end = now()->endOfMonth();
                break;
            case 'year':
                $start = now()->startOfYear();
                $end = now()->endOfYear();
                break;
            case 'today':
            default:
                $start = now()->startOfDay();
                $end = now()->endOfDay();
                break;
        }

        // Mendapatkan data tren
        $data = Trend::model(BahanBaku::class)
        ->between(
            start: now()->startOfYear(),
            end: now()->endOfYear(),
        )
        ->perMonth()
        ->count();

        return [
            'datasets' => [
                [
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#9BD0F5',
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }
    protected static string $color = 'danger';
    protected function getFilters(): ?array
    {
        return [
            'today' => 'Today',
            'week' => 'Last week',
            'month' => 'Last month',
            'year' => 'This year',
        ];
    }

    protected function getType(): string
    {
        return 'doughnut'; // Tipe grafik adalah doughnut
    }
}
