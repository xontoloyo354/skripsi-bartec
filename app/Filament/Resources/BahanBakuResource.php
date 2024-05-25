<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BahanBakuResource\Pages;
use App\Filament\Resources\BahanBakuResource\RelationManagers;
use App\Models\BahanBaku;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\FormsComponent;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BahanBakuResource extends Resource
{
    protected static ?string $model = BahanBaku::class;

    protected static ?string $navigationIcon = 'heroicon-s-archive-box';

    protected static ?string $navigationLabel = 'Bahan Baku';

    protected static ?string $modelLabel = 'Data Bahan Baku';

    protected static ?string $navigationGroup = 'Data WH. Baku';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('kode_material'),
                Forms\Components\Select::make('golongan')
                ->options([
                    'Plat - MS' => 'Plat - MS', 'Plat - Galvanil' => 'Plat - Galvanil', 'Plat - SS' => 'Plat - SS', 'Plat - Alumunium' => 'Plat - Alumunium', 'Plat - Plastik' => 'Plat - Plastik', 'Plat - Nylon' => 'Plat - Nylon', 'Plat - Kardus'=> 'Plat - Kardus', 'Plat - Karet'=> 'Plat - Karet', 'Plat - Timah'=> 'Plat - Timah', 'Plat - Gypsum'=> 'Plat - Gypsum', 'Plat - Border' => 'Plat - Border',
                    'Stall - MS' => 'Stall - MS', 'Stall - Profile'=>'Stall - Profile', 'Stall - SS' => 'Stall - SS', 'Stall - PVC' =>'Stall - PVC', 'Stall - Alumunium' => 'Stall - Alumunium', 'Stall - Plastik' =>'Stall - Plastik',
                    'Pipa - MS' => 'Pipa - MS',
                    'Pipa - Galvanis' => 'Pipa - Galvanis',
                    'Pipa - SS' => 'Pipa - SS',
                    'Pipa - Plasik' => 'Pipa - Plastik',
                    'Pipa - Tembaga' => 'Pipa - Tembaga',
                    'AS - MS' => 'AS - MS',
                    'AS - SS' => 'AS - SS',
                    'AS - Alumunium' => 'AS - Alumunium',
                    'AS - Nylon' => 'AS - Nylon',
                    'AS - Lain-Lain' => 'AS - Lain-Lain',
                    'Logam Lainnya' => 'Logam Lainnya',
                    'Kayu - Multiplek' => 'Kayu - Multiplek',
                    'Kayu - Vinyl' => 'Kayu - Vinyl',
                    'Kayu - HPL' => 'Kayu - HPL',
                    'PC & Kimia - Liquid' => 'PC & Kimia - Liquid',
                    'PC & Kimia - Powder' => 'PC & Kimia - Powder',
                    'PC & Kimia - Fiber' => 'PC & Kimia - Fiber',
                    'PC & Kimia - Foam' => 'PC & Kimia - Foam',
                    'PC & Kimia - Plastik & Polimer Lain' => 'PC & Kimia - Plastik & Polimer Lain',
                ]),
                Forms\Components\Select::make('jenis')->options([
                    'PEPEK' => 'PEPEK',
                ]),
                Forms\Components\TextInput::make('material'),
                Forms\Components\TextInput::make('satuan'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('No'),
                Tables\Columns\TextColumn::make('kode_material'),
                Tables\Columns\TextColumn::make('golongan'),
                Tables\Columns\TextColumn::make('jenis'),
                Tables\Columns\TextColumn::make('material'),
                Tables\Columns\TextColumn::make('satuan'),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListBahanBakus::route('/'),
            'create' => Pages\CreateBahanBaku::route('/create'),
            'edit' => Pages\EditBahanBaku::route('/{record}/edit'),
        ];
    }
}
