<?php

use App\Http\Controllers\BarangKeluarPDFController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangMasukPdfController;
use App\Models\User;
use Filament\Notifications\Notification;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
use Filament\Notifications\Events\DatabaseNotificationsSent;

Route::get('/', function () {
    return view('welcome');
});



Route::get('/barang-masuk/print/', [BarangMasukPDFController::class, 'printAll'])->name('printAll');
Route::get('/barang-masuk/print/{id}', [BarangMasukPDFController::class, 'downloadPdf'])->name('download.pdf');

Route::get('/barang-keluar/print/', [BarangKeluarPDFController::class, 'printOutAll'])->name('printOutAll');
Route::get('/barang-keluar/print/{id}', [BarangKeluarPDFController::class, 'downloadOutPdf'])->name('downloadOut.pdf');






