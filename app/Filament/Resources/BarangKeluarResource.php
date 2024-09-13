<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BarangKeluarResource\Pages;
use App\Filament\Resources\BarangKeluarResource\RelationManagers;
use App\Models\BarangKeluar;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\FormsComponent;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Carbon;
use Symfony\Component\CssSelector\Node\FunctionNode;

class BarangKeluarResource extends Resource
{
    protected static ?string $model = BarangKeluar::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    protected static ?string $navigationGroup = 'Form';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }


    public static function form(Form $form): Form
    {
                return $form
            ->schema([
                Forms\Components\Section::make('Shipping Details')
                ->schema([
                    Forms\Components\Grid::make(1)
                    ->schema([
                        Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Grid::make(1)
                        ->schema([
                            Forms\Components\TextInput::make('no_surat_keluar')
                        ->label('No. Surat Keluar')
                        ->required()
                        ->columnSpan(3),
                        Forms\Components\Grid::make(3)
                        ->schema([
                            Forms\Components\TextInput::make('acuan')
                        ->label('Acuan')
                        ->placeholder('Jenis Acuan')
                        ->required(),
                    Forms\Components\TextInput::make('no_acuan')
                        ->label('No. Acuan')
                        ->placeholder('No. Acuan')
                        ->required(),
                    Forms\Components\TextInput::make('tujuan')
                    ->label('Tujuan')
                    ->placeholder('Tujuan')
                    ->required(),        
                                ]),
                                Forms\Components\ToggleButtons::make('status')
                        ->label('Status')
                        ->reactive()
                        ->inline()
                        ->options([
                            'Setuju' => 'Setuju',
                            'Ditolak' => 'Ditolak',
                            'Menunggu' => 'Menunggu',
                        ])
                        ->colors([
                            'Setuju' => 'success',
                            'Ditolak' => 'danger',
                            'Menunggu' => 'info',
                        ])
                        ->icons([
                            'Setuju' => 'heroicon-m-sparkles',
                            'Ditolak' => 'heroicon-o-x-circle',
                            'Menunggu' => 'heroicon-m-clock',
                        ])
                        ->live()
                        ->default('Menunggu')
                        ->visible(fn (Forms\Get $get): bool => auth()->user()->role === 'Kepala Gudang'),
                        ]),
                    ]),
                    Forms\Components\Section::make('Identitas')
                    ->schema([
                        Forms\Components\Grid::make(3)
                        ->schema([
                            Forms\Components\TextInput::make('penerima')
                            ->label('Penerima')
                            ->placeholder('Nama Penerima')
                            ->required(),
                        Forms\Components\TextInput::make('pengambil')
                            ->label('Pengambil Barang')
                            ->placeholder('Nama Pengambil')
                            ->required(),
                        Forms\Components\TextInput::make('jabatan')
                            ->label('Jabatan')
                            ->placeholder('Jabatan Penerima')
                            ->required(),
                        Forms\Components\TextInput::make('security')
                            ->label('Security')
                            ->placeholder('Nama security yang mengetahui')
                            ->required(),
                        Forms\Components\TextInput::make('kendaraan')
                            ->label('Kendaraan')
                            ->placeholder('Jenis Kendaraan')
                            ->required(),
                        Forms\Components\TextInput::make('no_plat')
                            ->label('No. Plat Kendaraan')
                            ->placeholder('No Plat Kendaraan')
                            ->required(),
                        ]) 
                    ]),
                    ]),
                ]),  
                Forms\Components\Section::make('Barang Details')
                    ->schema([
                        Forms\Components\Grid::make(3)
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
                        Forms\Components\TextInput::make('keperluan')
                            ->label('Keperluan')
                            ->required(),
                        ]),
                    ]),

                ]);
    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('status')
                ->badge()
                ->icon(fn (string $state): string => match ($state){
                    'Setuju' => 'heroicon-o-check-circle',
                    'Ditolak' => 'heroicon-o-x-circle',
                    'Menunggu' => 'heroicon-o-clock',
                })
                ->color(fn (string $state): string => match ($state) {
                    'Setuju' => 'success',
                    'Ditolak' => 'danger',
                    'Menunggu' => 'warning',
                })
                ->sortable()
                ->label('Status'),
                TextColumn::make('no_surat_keluar')
                    ->label('No. Surat Keluar')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('acuan')
                    ->label('Acuan')
                    ->sortable()
                    ->searchable(),
                    TextColumn::make('no_acuan')
                    ->label('No. Acuan')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('bahanBaku.nama_barang')->label('Nama Barang')->sortable()->searchable()
                ->getStateUsing(function ($record) {
                    return $record->bahanBaku->nama_barang;
                }),
                TextColumn::make('penerima')
                    ->label('Penerima')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('pengambil')
                    ->label('Pengambil Barang')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('jabatan')
                    ->label('Jabatan')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('security')
                    ->label('Security')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('kendaraan')
                    ->label('Kendaraan')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('no_plat')
                    ->label('No. Plat Kendaraan')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('jumlah')
                ->label('Jumlah')
                ->sortable()
                ->searchable(),
                TextColumn::make('tujuan')
                ->label('Tujuan')
                ->sortable()
                ->searchable(),
            ])
            ->filters([
                Filter::make('created_at')
                ->form([
                    Forms\Components\DatePicker::make('created_from')->label('Mulai Tanggal'),
                    Forms\Components\DatePicker::make('created_until')->label('Sampai Tanggal'),
                    ])
            ->query(function (Builder $query, array $data): Builder {
                return $query
            ->when(
                $data['created_from'],
                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
            )
            ->when(
                $data['created_until'],
                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
            );
            })
            ->indicateUsing(function (array $data): array {
                $indicators = [];
                if ($data['created_from'] ?? null) {
                    $indicators['created_from'] = 'Created from ' . Carbon::parse($data['created_from'])->toFormattedDateString();
                }
                if ($data['created_until'] ?? null) {
                    $indicators['created_until'] = 'Created until ' . Carbon::parse($data['created_until'])->toFormattedDateString();
                }
                return $indicators;
            })
        ])->headerActions([
            Tables\Actions\Action::make('print')
            ->label('PDF')
            ->icon('heroicon-o-printer')
            ->url(fn() => route('printOutAll', [
                'created_from' => request('tableFilters')['created_at']['created_from'] ?? null,
                'created_until' => request('tableFilters')['created_at']['created_until'] ?? null,
                // 't' => time(),
            ]))
        ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\Action::make('Pdf')->label('Cetak')->icon('heroicon-m-printer')
                    ->url(fn(BarangKeluar $record) => route('downloadOut.pdf', $record))
                    ->openUrlInNewTab(),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ])
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

//     public static function infolist(Infolist $infolist): Infolist
// {
//     return $infolist
//         ->schema([
//             Section::make('Barang Details')
//             ->schema([
//                 TextEntry::make('bahanBaku.nama_barang')
//             ]),
//             Section::make('Shipping Details')
//             ->schema([
//                 TextEntry::make('no_surat_keluar')->label('No Surat Keluar'),
//                 TextEntry::make('acuan')->label('Acuan'),
//                 TextEntry::make('no_acuan'),
//                 TextEntry::make('tujuan'),
//             ])->columns(2),
//             Section::make('Identitas')
//             ->schema([
//                 TextEntry::make('penerima'),
//                 TextEntry::make('pengambil'),
//                 TextEntry::make('jabatan'),
//                 TextEntry::make('security'),
//                 TextEntry::make('kendaraan'),
//                 TextEntry::make('no_plat'),
//             ])->columns(3)
//             ]);
// }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBarangKeluars::route('/'),
            'create' => Pages\CreateBarangKeluar::route('/create'),
            'view' => Pages\ViewBarangKeluar::route('/{record}'),
            'edit' => Pages\EditBarangKeluar::route('/{record}/edit')
            ,
        ];
    }
    public static function canCreate(): bool
    {
        return auth()->user()->role == 'Admin';
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()->role == 'Admin';
    }
}
namespace App\Filament\Resources\BarangKeluarResource\Pages;

use App\Filament\Resources\BarangKeluarResource;
use App\Models\BahanBaku;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class CreateBarangKeluar extends CreateRecord
{
    protected static string $resource = BarangKeluarResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $bahanBaku = BahanBaku::find($data['bahan_baku_id']);

        if ($bahanBaku && $bahanBaku->stock < $data['jumlah']) {
            Notification::make()
                ->title('Stok Habis')
                ->body('Stok bahan baku tidak mencukupi untuk jumlah barang yang ingin dikeluarkan.')
                ->danger()
                ->send();

            $this->halt(); // Menghentikan proses penyimpanan data
        }

        return $data;
    }
}

class EditBarangKeluar extends EditRecord
{
    protected static string $resource = BarangKeluarResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $bahanBaku = BahanBaku::find($data['bahan_baku_id']);

        if ($bahanBaku && $bahanBaku->stock < $data['jumlah']) {
            Notification::make()
                ->title('Stok Habis')
                ->body('Stok bahan baku tidak mencukupi untuk jumlah barang yang ingin dikeluarkan.')
                ->danger()
                ->send();

            $this->halt(); // Menghentikan proses penyimpanan data
        }

        return $data;
    }
}