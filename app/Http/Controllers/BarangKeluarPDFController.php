<?php

namespace App\Http\Controllers;

use App\Models\BarangKeluar;
use App\Providers\PdfService;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;

class BarangKeluarPDFController extends Controller{

    public function printOutAll(Request $request)
    {
        $format = $request->get('format', 'pdf');
        $filters = $request->only(['created_from', 'created_until']);

        $barangKeluarQuery = BarangKeluar::query();

        if (!empty($filters['created_from'])) {
            $fromDate = Carbon::parse($filters['created_from'])->startOfDay();
            $barangKeluarQuery->where('created_at', '>=', $fromDate);
        }   
    
        if (!empty($filters['created_until'])) {
            $untilDate = Carbon::parse($filters['created_until'])->endOfDay();
            $barangKeluarQuery->where('created_at', '<=', $untilDate);
            Log::info('Filtering until date:', ['untilDate' => $untilDate]);
        }

        $barangKeluars = $barangKeluarQuery->with('bahanBaku')->get();

        $firstBarangKeluar = $barangKeluars->first();

        foreach ($barangKeluars as $barangKeluar) {
            Log::info('BarangKeluar item:', ['id' => $barangKeluar->id, 'created_at' => $barangKeluar->created_at]);
        }

        Log::info('Filters:', $filters);
        Log::info('Filtered BarangKeluar count:', ['count' => $barangKeluars->count()]);
        if ($format === 'pdf'){
            $pdf = PDF::loadView('pdf.barang_keluar', compact('barangKeluars', 'firstBarangKeluar'));

            return $pdf->stream('barang-keluar.pdf');
        }
        
        return response()->json([
            'barangKeluars' =>$barangKeluars,
            'firstBarangKeluar' => $firstBarangKeluar,
        ]);

    }

    public function downloadOutPdf($id)
{
    // Fetch the data for the PDF
    $barangKeluar = BarangKeluar::find($id);
    if (!$barangKeluar) {
        return abort(404, 'Barang Masuk not found');
    }

    $barangKeluars = BarangKeluar::where('id', $id)->with('bahanBaku')->get();
    $firstBarangKeluar = $barangKeluars->first();

    // Generate PDF
    $pdf = Pdf::loadView('pdf.barang_keluar', compact('barangKeluars', 'firstBarangKeluar'));
    return $pdf->stream('barang-keluar.pdf');
}
}