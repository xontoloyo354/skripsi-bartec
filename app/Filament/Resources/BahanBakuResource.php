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
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;
use NunoMaduro\Collision\Adapters\Phpunit\State;
use PhpParser\ErrorHandler\Collecting;

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
                Forms\Components\Select::make('golongan_id') ->label('Golongan')
                ->options(Golongan::all()->pluck('name', 'id')->toArray()),
                Forms\Components\Select::make('jenis_id') 
                ->label('Jenis')
                ->options(Jenis::all()->pluck('name', 'id')->toArray()),
                Forms\Components\TextInput::make('sub_jenis'),
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
                Tables\Columns\TextColumn::make('golongan.name'),
                Tables\Columns\TextColumn::make('jenis.name'),
                Tables\Columns\TextColumn::make('sub_jenis'),
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
