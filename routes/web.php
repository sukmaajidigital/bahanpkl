<?php

use App\Http\Controllers\BahanBakuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KategoriLaporanController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\PengeluaranKasirController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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
Route::get('/', function () {
    return view('auth.login');
});

Route::group(['prefix' => 'dashboard', 'middleware' => ['auth', 'verified']], function(){
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('/kategori', KategoriController::class);
    Route::resource('/bahanbaku', BahanBakuController::class);

    Route::resource('user', UserController::class);
    Route::resource('role', RoleController::class);

    // settings
    Route::get('/settings', [PengaturanController::class, 'index'])->name('settings');
    Route::put('/settings/onupdate/{id}', [PengaturanController::class, 'on'])->name('settings.on');
    Route::put('/settings/offupdate/{id}', [PengaturanController::class, 'off'])->name('settings.off');

    // pembelian
    Route::get('/pembelian', [PembelianController::class, 'index'])->name('pembelian');
    Route::get('/pembelian/search', [PembelianController::class, 'search'])->name('pembelian.search');
    Route::post('/pembelian/store', [PembelianController::class, 'store'])->name('pembelian.store');
    Route::get('/pembelian/bahanbaku', [PembelianController::class, 'bahanBaku'])->name('pembelianBahanBaku');
    Route::post('/pembelian/bahanbaku/store', [PembelianController::class, 'bahanBakuStore'])->name('pembelianBahanBaku.store');
    Route::get('/pembelian/edit/{id}', [PembelianController::class, 'edit'])->name('pembelian.edit');
    Route::put('/pembelian/update/{id}', [PembelianController::class, 'update'])->name('pembelian.update');
    Route::delete('/pembelian/delete/{id}', [PembelianController::class, 'destroy'])->name('pembelian.destroy');

    //pengeluaran kasir
    Route::get('/pengeluaran-kasir', [PengeluaranKasirController::class, 'index'])->name('kasir-keluar');
    Route::post('/pengeluaran-kasir/barang/store', [PengeluaranKasirController::class, 'barangStore'])->name('pengeluaranKasirBarang.store');

    // pengeluaran
    Route::get('/barang-keluar', [PengeluaranController::class, 'index'])->name('pengeluaran');
    route::post('/pengeluaran/store', [PengeluaranController::class, 'store'])->name('pengeluaran.store');
    Route::get('/barang-keluar/edit/{id}', [PengeluaranController::class, 'edit'])->name('pengeluaran.edit');
    Route::put('/barang-keluar/update/{id}', [PengeluaranController::class, 'update'])->name('pengeluaran.update');

    //stok
    Route::get('/stok', [StokController::class, 'index'])->name('stok.index');
    Route::get('/stok/edit/{id}', [StokController::class, 'edit'])->name('stok.edit');
    Route::put('/stok/update/{id}', [StokController::class, 'update'])->name('stok.update');

    // laporan
    Route::get('laporan-bulanan', [ReportController::class, 'bulanan'])->name('laporan.bulanan');
    Route::get('laporan-bulanan/cetak/{startDate}', [ReportController::class, 'generatePDF'])->name('generatePDF');
    Route::get('laporan-per-kategori/{id}', [KategoriLaporanController::class, 'bulanan'])->name('laporan.kategori');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
