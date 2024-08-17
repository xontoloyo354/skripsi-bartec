<?php

namespace App\Providers;

use App\Models\BahanBaku;
use App\Observers\BahanBakuObserver;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        BahanBaku::observe(BahanBakuObserver::class);
    }
}