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

    public function printAll(Request $request)
{

    $format = $request->get('format', 'pdf');
    $filters = $request->only(['created_from', 'created_until']);

    $barangMasukQuery = BarangMasuk::query();

    if (!empty($filters['created_from'])) {
        $fromDate = Carbon::parse($filters['created_from'])->startOfDay();
        $barangMasukQuery->where('created_at', '>=', $fromDate);
    }   

    if (!empty($filters['created_until'])) {
        $untilDate = Carbon::parse($filters['created_until'])->endOfDay();
        $barangMasukQuery->where('created_at', '<=', $untilDate);
        Log::info('Filtering until date:', ['untilDate' => $untilDate]);
    }

    $barangMasuks = $barangMasukQuery->with('bahanBaku')->get();   
    $firstBarangMasuk = $barangMasuks->first();

    // dd($firstBarangMasuk);

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

public function downloadPdf($id)
{
    // Fetch the data for the PDF
    $barangMasuk = BarangMasuk::find($id);
    if (!$barangMasuk) {
        return abort(404, 'Barang Masuk not found');
    }

    $barangMasuks = BarangMasuk::where('id', $id)->with('bahanBaku')->get();
    $firstBarangMasuk = $barangMasuks->first();

    // Generate PDF
    $pdf = Pdf::loadView('pdf.barang_masuk', compact('barangMasuks', 'firstBarangMasuk'));
    return $pdf->stream('barang-masuk.pdf');
}
}
