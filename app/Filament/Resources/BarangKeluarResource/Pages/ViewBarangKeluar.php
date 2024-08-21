<?php

namespace App\Filament\Resources\BarangKeluarResource\Pages;

use App\Filament\Resources\BarangKeluarResource;
use App\Models\User;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

class ViewBarangKeluar extends ViewRecord
{
    protected static string $resource = BarangKeluarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('disetujui')
            ->label('Disetujui')
            ->color('success')
            ->icon('heroicon-o-check-circle')
            ->action(function () {
                // Mengubah status tanpa memicu event updated
                \Illuminate\Database\Eloquent\Model::withoutEvents(function () {
                    $this->record->update(['status' => 'Setuju']);
                });

                $users = User::where('role', 'Admin')->get();

                foreach ($users as $user) {
                    Notification::make()
                        ->title('Barang Keluar telah disetujui.')
                        ->body("No surat jalan {$this->record->no_surat_keluar} telah disetujui.")
                        ->success()
                        ->send()
                        ->sendToDatabase($user);
                }
            })
            ->visible(fn () => auth()->user()->role === 'Kepala Gudang'),

        Actions\Action::make('ditolak')
            ->label('Ditolak')
            ->color('danger')
            ->icon('heroicon-o-x-circle')
            ->action(function () {
                // Mengubah status tanpa memicu event updated
                \Illuminate\Database\Eloquent\Model::withoutEvents(function () {
                    $this->record->update(['status' => 'Ditolak']);
                });

                $users = User::where('role', 'Admin')->get();

                foreach ($users as $user) {
                    Notification::make()
                        ->title('Barang Keluar telah ditolak.')
                        ->body("No surat jalan {$this->record->no_surat_keluar} telah ditolak.")
                        ->danger()
                        ->send()
                        ->sendToDatabase($user);
                }
            })
            ->visible(fn () => auth()->user()->role === 'Kepala Gudang'),
    ];
    }
}
