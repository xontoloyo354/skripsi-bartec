<?php

namespace App\Http\Controllers;

use App\Models\BarangMasuk;
use App\Providers\PdfService;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\View;

class BarangMasukPDFController extends Controller
{
    public function print($id)
    {
        $barangMasuk = BarangMasuk::with('bahanBaku')->findOrFail($id);
        $barangMasukList = BarangMasuk::with('bahanBaku')->get();

        $pdf = PDF::loadView('pdf.barang_masuk', compact('barangMasuk', 'barangMasukList'));
        return $pdf->stream('surat_pemberitahuan_barang_datang.pdf');

        set_time_limit(300);
    }
}
