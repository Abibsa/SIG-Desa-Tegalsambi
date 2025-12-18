<?php

namespace App\Http\Controllers;

use App\Models\Wilayah;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function exportPDF()
    {
        $wilayahs = Wilayah::all();

        // Simple HTML export if DomPDF not installed
        $html = view('exports.wilayah-pdf', compact('wilayahs'))->render();

        return response($html)
            ->header('Content-Type', 'text/html')
            ->header('Content-Disposition', 'attachment; filename="laporan-wilayah.html"');
    }

    public function exportCSV()
    {
        $wilayahs = Wilayah::all();

        $filename = 'data-wilayah-' . date('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($wilayahs) {
            $file = fopen('php://output', 'w');

            // Header
            fputcsv($file, ['ID', 'Tingkat', 'Nama Wilayah', 'KK', 'Laki-laki', 'Perempuan', 'Total Penduduk']);

            // Data
            foreach ($wilayahs as $wilayah) {
                fputcsv($file, [
                    $wilayah->id,
                    strtoupper($wilayah->tingkat),
                    $wilayah->nama,
                    $wilayah->kk,
                    $wilayah->l,
                    $wilayah->p,
                    $wilayah->l + $wilayah->p,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
