<?php

namespace App\Observers;

use App\Models\BahanBaku;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class BahanBakuObserver
{
    /**
     * Handle the BahanBaku "created" event.
     */
    public function created(BahanBaku $bahanBaku): void
    {
        $users = User::where('role', 'Admin')->get();

        foreach ($users as $user) {
            Notification::make()
                ->title('New Bahan Baku Created')
                ->icon('heroicon-o-plus-circle')
                ->body('A new Bahan Baku has been created.')
                ->sendToDatabase($user);
        }
    }

    /**
     * Handle the BahanBaku "updated" event.
     */
    public function updated(BahanBaku $bahanBaku): void
{
    try {
        // Check if the stock field is dirty (changed)
        if ($bahanBaku->isDirty('stock')) {
            $lowStockItems = BahanBaku::where('stock', '<=', 10)->count();
            $users = User::where('role', 'Admin')->get();

            // Check if there are any users with the Admin role
            if ($users->count() > 0) {
                foreach ($users as $user) {
                    // Check if the stock field is less than or equal to 10
                    if ($bahanBaku->stock <= 10) {
                        Notification::make()
                            ->title('Bahan Baku Updated')
                            ->success()
                            ->icon('heroicon-o-exclamation-circle')
                            ->iconColor('warning')
                            ->body("There are {$lowStockItems} items with low stock.")
                            ->actions([
                                Action::make('view')
                                    ->button()
                                    ->url(route('filament.admin.resources.bahan-bakus.index'), shouldOpenInNewTab: true) // Adjust this route as necessary
                                    ->markAsRead(),
                            ])
                            ->sendToDatabase($user);
                    }
                }
            }
        }
    } catch (\Exception $e) {
        // Log the exception or perform any necessary error handling
        Log::error($e->getMessage());
    }
}

    /**
     * Handle the BahanBaku "deleted" event.
     */
    public function deleted(BahanBaku $bahanBaku): void
    {
        //
    }

    /**
     * Handle the BahanBaku "restored" event.
     */
    public function restored(BahanBaku $bahanBaku): void
    {
        //
    }

    /**
     * Handle the BahanBaku "force deleted" event.
     */
    public function forceDeleted(BahanBaku $bahanBaku): void
    {
        //
    }
}
