<?php

// namespace App\Filament\Widgets;

// use App\Models\BahanBaku;
// use Flowframe\Trend\Trend;
// use Flowframe\Trend\TrendValue;
// use Filament\Widgets\ChartWidget;

// class BahanBakuChart extends ChartWidget
// {
//     public ?string $filter = 'month'; // Set default filter
//     public static ?string $heading = 'Bahan Baku Chart';
//     protected static ?int $sort = 7;

    

//     protected function getData(): array
// {   
//     $activeFilter = $this->filter;
//     $data = collect();

//         switch ($activeFilter) {
//             case 'today':
//                 $start = now()->startOfDay();
//                 $end = now()->endOfDay();
//                 $data = Trend::model(BahanBaku::class)
//                     ->between(start: $start, end: $end)
//                     ->perHour()
//                     ->count();
//                 break;
                
//             case 'week':
//                 $start = now()->startOfWeek();
//                 $end = now()->endOfWeek();
//                 $data = Trend::model(BahanBaku::class)
//                     ->between(start: $start, end: $end)
//                     ->perDay()
//                     ->count();
//                 break;
                
//             case 'month':
//                 $start = now()->startOfMonth();
//                 $end = now()->endOfMonth();
//                 $data = Trend::model(BahanBaku::class)
//                     ->between(start: $start, end: $end)
//                     ->perDay()
//                     ->count();
//                 break;
                
//             case 'year':
//             default:
//                 $start = now()->startOfYear();
//                 $end = now()->endOfYear();
//                 $data = Trend::model(BahanBaku::class)
//                     ->between(start: $start, end: $end)
//                     ->perMonth()
//                     ->count();
//                 break;
//         }

//     return [
//         'datasets' => [
//             [
//                 'label' => 'Bahan Baku',
//                 'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
//             ],
//         ],
//         'labels' => $data->map(fn (TrendValue $value) => $value->date),    
        
//     ];
    
// }
// protected function getFilters(): ?array
// {
//     return [
//         'today' => 'Today',
//         'week' => 'Last week',
//         'month' => 'Last month',
//         'year' => 'This year',
//     ];
// }

//     protected function getType(): string
//     {
//         return 'line'; // Tipe grafik adalah doughnut
//     }
// }
