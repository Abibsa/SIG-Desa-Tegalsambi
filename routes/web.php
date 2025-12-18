<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MapController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MapController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    // Ambil Data Riil dari Database
    $totalWilayah = \App\Models\Wilayah::where('tingkat', 'rw')->count();

    // Ambil Total Penduduk dari tingkat Desa (Data Agregat)
    $desa = \App\Models\Wilayah::where('tingkat', 'desa')->first();
    $totalPenduduk = $desa ? ($desa->l + $desa->p) : 0;

    // Hitung Kepadatan (Asumsi luas desa +/- 150 Ha untuk simulasi, atau ambil dari data jika ada)
    // 5475 jiwa / 150 Ha = ~36 jiwa/Ha
    $kepadatan = $totalPenduduk > 0 ? round($totalPenduduk / 150) : 0;

    // Data tambahan untuk chart atau list
    $rws = \App\Models\Wilayah::where('tingkat', 'rw')->orderBy('nama')->get();

    return view('dashboard', compact('totalWilayah', 'totalPenduduk', 'kepadatan', 'rws'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin Routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('wilayah', \App\Http\Controllers\Admin\WilayahController::class);
        Route::resource('poi', \App\Http\Controllers\Admin\PoiController::class);

        // Demografi Routes
        Route::get('demografi/{type}', [\App\Http\Controllers\Admin\DemografiController::class, 'index'])->name('demografi.index');
        Route::put('demografi/{type}', [\App\Http\Controllers\Admin\DemografiController::class, 'update'])->name('demografi.update');
        Route::delete('demografi/{type}/{id}', [\App\Http\Controllers\Admin\DemografiController::class, 'destroy'])->name('demografi.destroy');
    });

    // Export Routes
    Route::get('/export/pdf', [\App\Http\Controllers\ExportController::class, 'exportPDF'])->name('export.pdf');
    Route::get('/export/csv', [\App\Http\Controllers\ExportController::class, 'exportCSV'])->name('export.csv');
});

// Public Data Routes
Route::get('/api/poi-geojson', [MapController::class, 'poiGeoJson'])->name('api.poi.geojson');
Route::get('/api/rw-geojson', [MapController::class, 'rwGeoJson'])->name('api.rw.geojson');
Route::get('/api/desa-stats', [MapController::class, 'desaStats'])->name('api.desa.stats');

require __DIR__ . '/auth.php';
