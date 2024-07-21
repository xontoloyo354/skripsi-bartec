<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BarangMasukResource\Pages;
use App\Filament\Resources\BarangMasukResource\RelationManagers;
use App\Models\BahanBaku;
use App\Models\BarangMasuk;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BarangMasukResource extends Resource
{
    protected static ?string $model = BarangMasuk::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Form';


    public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\TextInput::make('no_surat_masuk')
                ->label('No. Surat Masuk')
                ->disabled(),
            Forms\Components\Section::make('Barang Details')
                ->schema([
                    Forms\Components\Grid::make(2)
                    ->schema([
                    Forms\Components\Select::make('bahan_baku_id')
                        ->label('Nama Barang')
                        ->options(function () {
                            return \App\Models\BahanBaku::all()->pluck('nama_barang', 'id');
                            })
                        ->required()
                        ->preload(),
                    Forms\Components\TextInput::make('jumlah')
                        ->required()
                        ->numeric()
                        ->placeholder('Masukan jumlah barang yang masuk ')
                        ->label('Jumlah'),
                ]),
            ]),
                Forms\Components\Section::make('Shipping Details')
                ->schema([
                    Forms\Components\Grid::make(3)
                        ->schema([
                            Forms\Components\TextInput::make('no_surat_jalan')
                                ->required()
                                ->placeholder('No surat jalan pengirim')
                                ->label('No. Surat Jalan')
                                ->columnSpan(3),
                            Forms\Components\TextInput::make('pembawa')
                                ->required()
                                ->label('Pembawa')
                                ->placeholder('Nama pembawa barang')
                                ->columnSpan(2),
                            Forms\Components\TextInput::make('posisi')
                                ->label('Posisi')
                                ->placeholder('Bagian pengirim barang ')
                                ->columnSpan(1),
                            Forms\Components\TextInput::make('kendaraan')
                                ->required()
                                ->label('Kendaraan')
                                ->placeholder('Jenis kendaraan yang dibawa')
                                ->columnSpan(2),
                            Forms\Components\TextInput::make('no_plat')
                                ->required()
                                ->label('No Plat')
                                ->placeholder('No plat kendaraan')
                                ->columnSpan(1),
                        ]),
                ]),
            
            ]);
        
}

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('no_surat_masuk')->label('No. Surat Masuk')
                ->searchable(),
                Tables\Columns\TextColumn::make('bahanBaku.nama_barang')->label('Nama Barang')
                ->searchable()
                ->getStateUsing(function ($record) {
                    return $record->bahanBaku->nama_barang;
                }),
                Tables\Columns\TextColumn::make('no_surat_jalan')->label('No. Surat Jalan')
                ->searchable(),
                Tables\Columns\TextColumn::make('pembawa')->label('Pembawa')
                ->searchable(),
                Tables\Columns\TextColumn::make('posisi')->label('Posisi')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('kendaraan')->label('Kendaraan')->searchable(),
                Tables\Columns\TextColumn::make('no_plat')->label('No Plat')->searchable(),
                Tables\Columns\TextColumn::make('jumlah')->label('Jumlah')->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
        }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBarangMasuks::route('/'),
            'create' => Pages\CreateBarangMasuk::route('/create'),
            'view' => Pages\ViewBarangMasuk::route('/{record}'),
            'edit' => Pages\EditBarangMasuk::route('/{record}/edit'),
        ];
    }
}   
