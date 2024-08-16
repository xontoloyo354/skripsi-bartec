<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BahanBakuResource\Pages;
use App\Filament\Resources\BahanBakuResource\RelationManagers;
use App\Models\BahanBaku;
use App\Models\Golongan;
use App\Models\Jenis;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\FormsComponent;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;
use NunoMaduro\Collision\Adapters\Phpunit\State;
use PhpParser\ErrorHandler\Collecting;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction as TablesExportBulkAction;

class BahanBakuResource extends Resource
{
    protected static ?string $model = BahanBaku::class;

    protected static ?string $navigationIcon = 'heroicon-s-archive-box';

    protected static ?string $navigationLabel = 'Bahan Baku';

    protected static ?string $modelLabel = 'Data Bahan Baku';

    protected static ?string $navigationGroup = 'Data WH. Baku';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('kode_material')
                ->disabled()
                ->dehydrated(false)
                ->helperText('Generate Kode'),

                Forms\Components\Select::make('golongan_id') ->label('Golongan')
                ->options(Golongan::all()->pluck('name', 'id')->toArray()),

                Forms\Components\Select::make('jenis_id') 
                ->label('Jenis')
                ->options(Jenis::all()->pluck('name', 'id')->toArray()),

                Forms\Components\TextInput::make('sub_jenis')
                ->required(),

                Forms\Components\TextInput::make('material')
                ->required(),

                Forms\Components\TextInput::make('satuan')
                ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nomor')
                ->sortable()
                ->label('No'),
                Tables\Columns\TextColumn::make('kode_material'),
                Tables\Columns\TextColumn::make('golongan.name')
                ->sortable()
                ->searchable(),
                Tables\Columns\TextColumn::make('jenis.name')
                ->sortable()
                ->searchable(),
                Tables\Columns\TextColumn::make('sub_jenis')
                ->label('Detail Jenis'),
                Tables\Columns\TextColumn::make('material')
                ->label('Detail Material'),
                Tables\Columns\TextColumn::make('satuan'),
                Tables\Columns\TextColumn::make('stock')
                ->label('Stock')
                ->sortable(),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                Tables\Actions\EditAction::make()
                ->slideOver(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
                ]),
                
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    TablesExportBulkAction::make(),
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
