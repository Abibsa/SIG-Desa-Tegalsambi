<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class PoiSeeder extends Seeder
{
    public function run(): void
    {
        // Path ke GeoJSON yang sudah lengkap tadi
        $jsonPath = public_path('geojson/POI_Tegalsambi.geojson');

        if (!File::exists($jsonPath)) {
            echo "File GeoJSON tidak ditemukan: $jsonPath\n";
            return;
        }

        $json = File::get($jsonPath);
        $data = json_decode($json, true);

        DB::table('pois')->truncate();

        foreach ($data['features'] as $feature) {
            $props = $feature['properties'];
            $coords = $feature['geometry']['coordinates']; // [Lon, Lat]

            DB::table('pois')->insert([
                'nama' => $props['nama'],
                'kategori' => $props['kategori_label'] ?? $props['kategori'], // Pakai label asli jika ada
                'jenis' => $props['jenis'] ?? null,
                'alamat' => $props['alamat'] ?? null,
                'kontak' => $props['kontak'] ?? null,
                'fasilitas' => $props['fasilitas'] ?? null,
                'pengelola' => $props['pengelola'] ?? null,
                'web' => $props['web'] ?? null,
                'deskripsi' => null,
                'latitude' => $coords[1],
                'longitude' => $coords[0], // GeoJSON is Lon, Lat
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        echo "Berhasil import " . count($data['features']) . " POI ke Database.\n";
    }
}
