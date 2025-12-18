<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Poi;
use App\Models\Wilayah;
use App\Models\Pendidikan;
use App\Models\Pekerjaan;
use App\Models\Agama;
use App\Models\Umur;

class MapController extends Controller
{
    public function index()
    {
        return view('map');
    }

    public function poiGeoJson()
    {
        $pois = Poi::all();

        $features = [];
        foreach ($pois as $poi) {
            $features[] = [
                'type' => 'Feature',
                'properties' => [
                    'id' => $poi->id,
                    'nama' => $poi->nama,
                    'kategori' => $poi->kategori, // Use actual DB value by default
                    'kategori_label' => $poi->kategori,
                    'jenis' => $poi->jenis,
                    'alamat' => $poi->alamat,
                    'kontak' => $poi->kontak,
                    'fasilitas' => $poi->fasilitas,
                    'pengelola' => $poi->pengelola,
                    'web' => $poi->web
                ],
                'geometry' => [
                    'type' => 'Point',
                    'coordinates' => [$poi->longitude, $poi->latitude]
                ]
            ];
        }

        // Logic Icon Mapping (Normalization)
        foreach ($features as &$f) {
            $label = $f['properties']['kategori_label'];
            $nama = $f['properties']['nama'];

            // 1. Normalize ambiguous terms
            if ($label == 'Tempat Ibadah')
                $f['properties']['kategori'] = 'Agama';

            // 2. Smart Icon Detection based on Name
            // Jika kategori 'Agama', cek apakah nama mengandung 'Masjid' atau 'Musholla'
            if ($f['properties']['kategori'] == 'Agama') {
                if (stripos($nama, 'Masjid') !== false) {
                    $f['properties']['kategori'] = 'Masjid';
                } elseif (stripos($nama, 'Musholla') !== false || stripos($nama, 'Mushola') !== false || stripos($nama, 'Langgar') !== false) {
                    $f['properties']['kategori'] = 'Musholla';
                }
            }
        }

        return response()->json([
            'type' => 'FeatureCollection',
            'features' => $features
        ]);
    }

    public function rwGeoJson()
    {
        // 1. Ambil Geometri dasar dari file GeoJSON (Bentuk Peta)
        $path = public_path('geojson/RW_Tegalsambi.geojson');
        if (!file_exists($path)) {
            return response()->json(['error' => 'File GeoJSON not found'], 404);
        }
        $json = json_decode(file_get_contents($path), true);

        // 2. Ambil Data Penduduk Terbaru dari Database
        // Kita ambil semua RW (tingkat='rw')
        $dbWilayah = Wilayah::where('tingkat', 'rw')->get()->keyBy('nama');

        // 3. Gabungkan (Merge)
        foreach ($json['features'] as &$feature) {
            $namaRW = $feature['properties']['nama']; // Contoh: "RW 01 (GEGUNUNG)"

            // Cari data di DB yang cocok namanya
            // Kita coba cocokan stringnya.
            // Di Seeder: "RW 01 (GEGUNUNG)"
            // Di GeoJSON: "RW 01 (GEGUNUNG)"

            if (isset($dbWilayah[$namaRW])) {
                $data = $dbWilayah[$namaRW];

                // Timpa properti GeoJSON dengan Data DB Terbaru
                $feature['properties']['kk'] = $data->kk;
                $feature['properties']['total'] = $data->l + $data->p;
                $feature['properties']['laki'] = $data->l;
                $feature['properties']['perempuan'] = $data->p;

                // Hitung kepadatan (Dummy luas for now, or keep existing)
                // Jika ingin dinamis, kepadatan = total / luas.
                // Kita pakai logic pewarnaan yang ada di blade saja based on total population for now.
                $feature['properties']['kepadatan'] = ($data->l + $data->p) * 20; // Simulasi angka kepadatan agar warna keluar
            } else {
                // Coba Normalisasi Nama (Misal: "RW 01" -> "RW 001")
                $normalized = preg_replace('/RW 0(\d)\s/', 'RW 00$1 ', $namaRW);
                if (isset($dbWilayah[$normalized])) {
                    $data = $dbWilayah[$normalized];
                    $feature['properties']['kk'] = $data->kk;
                    $feature['properties']['total'] = $data->l + $data->p;
                    $feature['properties']['laki'] = $data->l;
                    $feature['properties']['perempuan'] = $data->p;
                    $feature['properties']['kepadatan'] = ($data->l + $data->p) * 20;
                }
            }
        }

        return response()->json($json);
    }
    public function desaStats()
    {
        $desa = Wilayah::where('tingkat', 'desa')->first();
        if (!$desa)
            return response()->json(['error' => 'Data Desa not found'], 404);

        // Aggregasi Data Penduduk dari tingkat RW (agar sinkron dengan update RW di Admin)
        $totalKK = Wilayah::where('tingkat', 'rw')->sum('kk');
        $totalL = Wilayah::where('tingkat', 'rw')->sum('l');
        $totalP = Wilayah::where('tingkat', 'rw')->sum('p');
        $totalPenduduk = $totalL + $totalP;

        // Ambil Data Demografi (tetap based on Wilayah Desa ID for now, unless demography also broken down)
        $pendidikan = Pendidikan::where('wilayah_id', $desa->id)->get();
        $pekerjaan = Pekerjaan::where('wilayah_id', $desa->id)->orderBy('jumlah', 'desc')->take(10)->get(); // Top 10
        $agama = Agama::where('wilayah_id', $desa->id)->get();
        $umur = Umur::where('wilayah_id', $desa->id)->get();

        return response()->json([
            'penduduk' => [
                'total' => $totalPenduduk,
                'laki' => $totalL,
                'perempuan' => $totalP,
                'kk' => $totalKK
            ],
            'pendidikan' => $pendidikan->map(fn($i) => ['label' => $i->tingkat_pendidikan, 'value' => $i->jumlah]),
            'pekerjaan' => $pekerjaan->map(fn($i) => ['label' => $i->jenis_pekerjaan, 'value' => $i->jumlah]),
            'agama' => $agama->map(fn($i) => ['label' => $i->agama, 'value' => $i->jumlah]),
            'umur' => $umur->map(fn($i) => ['label' => $i->rentang_umur, 'value' => $i->jumlah]),
        ]);
    }
}
