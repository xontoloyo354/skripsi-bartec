<?php

namespace App\Providers;

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
        //
    }
}
class PdfService
{
    public function generateBarangMasukPdf($barangMasuk)
    {
        $pdf = Pdf::loadView('pdf.barang_masuk', ['barangMasuk' => $barangMasuk]);
        return $pdf->download('barang_masuk_' . $barangMasuk->no_surat_masuk . '.pdf');
    }
}
