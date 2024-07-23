<?php

namespace App\Http\Controllers;

use App\Models\BarangMasuk;
use App\Providers\PdfService;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;

class BarangMasukPDFController extends Controller
{
    // public function print($id)
    // {
    //     $barangMasuk = BarangMasuk::with('bahanBaku')->findOrFail($id);
    //     $barangMasukList = BarangMasuk::with('bahanBaku')->get();

    //     $pdf = PDF::loadView('pdf.barang_masuk', compact('barangMasuk', 'barangMasukList'));
    //     return $pdf->download('Surat_Barang_Masuk.pdf');

    //     set_time_limit(300);
    // }

    // public function printAll(Request $request)
    // {
    //     $filters = $request->only(['created_from', 'created_until']);

    //     $barangMasukQuery = BarangMasuk::query();

    //     if (!empty($filters['created_from'])) {
    //         $barangMasukQuery->whereDate('created_at', '>=', $filters['created_from']);
    //     }
    
    //     if (!empty($filters['created_until'])) {
    //         $barangMasukQuery->whereDate('created_at', '<=', $filters['created_until']);
    //     }

    //     $finalQuery = $barangMasukQuery->toSql();
    //     Log::info('BarangMasuk query: ' . $finalQuery, $barangMasukQuery->getBindings());
        

    //     $barangMasuks = $barangMasukQuery->with('bahanBaku')->get();
    //     $firstBarangMasuk = $barangMasuks->first();


    //     Log::info('Filtered BarangMasuk count: ' . $barangMasuks->count());

    //     $pdf = PDF::loadView('pdf.barang_masuk', compact('barangMasuks','firstBarangMasuk'));
    //     return $pdf->stream('barang-masuk.pdf');
    // }
    public function printAll(Request $request)
{
    Cache::forget('barangMasukQuery');

    $format = $request->get('format', 'pdf');

    $filters = $request->only(['created_from', 'created_until']);
    Log::info('Filters: ', $filters);

    $barangMasukQuery = BarangMasuk::query();

    

    if (!empty($filters['created_from'])) {
        $fromDate = Carbon::parse($filters['created_from'])->startOfDay();
        $barangMasukQuery->where('created_at', '>=', $fromDate);
    }   

    if (!empty($filters['created_until'])) {
        $untilDate = Carbon::parse($filters['created_until'])->endOfDay();
        $barangMasukQuery->where('created_at', '<=', $untilDate);
    }

    $barangMasuks = $barangMasukQuery->with('bahanBaku')->get();
    $firstBarangMasuk = $barangMasuks->first();

    // dd($barangMasuks);
    // dd($barangMasukQuery->toSql(), $barangMasukQuery->getBindings());
    // Log::info('Filtered BarangMasuk count: ' . $barangMasuks->count());

    if ($format === 'pdf') {
        $pdf = PDF::loadView('pdf.barang_masuk', compact('barangMasuks', 'firstBarangMasuk'));
        return $pdf->stream('barang-masuk.pdf');
    }

    return response()->json([
        'barangMasuks' => $barangMasuks,
        'firstBarangMasuk' => $firstBarangMasuk,
    ]);

    //... rest of your code
    
}

public function barangmasukPdf($id)
{

}
}
