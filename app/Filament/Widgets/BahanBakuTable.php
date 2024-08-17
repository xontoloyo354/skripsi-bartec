<?php

namespace App\Filament\Widgets;

use App\Models\BahanBaku;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class BahanBakuTable extends BaseWidget
{
    protected static ?int $sort = 7;
    protected int | string | array $columnSpan = 'full';
    public function table(Table $table): Table
    {
        return $table
            ->query(BahanBaku::query())
            ->defaultSort('id', 'asc')
            ->columns([
            Tables\Columns\TextColumn::make('nomor')->label('No'),
            Tables\Columns\TextColumn::make('kode_material')->label('Kode Material')
            ->sortable()
            ,
            Tables\Columns\TextColumn::make('golongan.name')->label('Golongan')
            ->searchable(),
            Tables\Columns\TextColumn::make('jenis.name')->label('Jenis')
            ->searchable(),
            Tables\Columns\TextColumn::make('stock')->label('Stock'),
            ])
            ->searchOnBlur();
    }
}
