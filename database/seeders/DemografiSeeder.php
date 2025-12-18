<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DemografiSeeder extends Seeder
{
    public function run(): void
    {
        // Bersihkan tabel
        DB::table('pendidikans')->truncate();
        DB::table('pekerjaans')->truncate();
        DB::table('agamas')->truncate();
        DB::table('umurs')->truncate();

        // Ambil ID Desa Tegalsambi (parent_id = null)
        $desa = DB::table('wilayahs')->where('tingkat', 'desa')->first();

        if (!$desa) {
            echo "Error: Desa Tegalsambi not found. Run WilayahSeeder first.\n";
            return;
        }

        $desaId = $desa->id;

        // 1. DATA PENDIDIKAN
        $pendidikan = [
            ['kelompok' => 'TIDAK / BELUM SEKOLAH', 'jumlah' => 1600],
            ['kelompok' => 'BELUM TAMAT SD/SEDERAJAT', 'jumlah' => 391],
            ['kelompok' => 'TAMAT SD / SEDERAJAT', 'jumlah' => 1126],
            ['kelompok' => 'SLTP/SEDERAJAT', 'jumlah' => 1195],
            ['kelompok' => 'SLTA / SEDERAJAT', 'jumlah' => 934],
            ['kelompok' => 'DIPLOMA I / II', 'jumlah' => 20],
            ['kelompok' => 'AKADEMI/ DIPLOMA III/S. MUDA', 'jumlah' => 37],
            ['kelompok' => 'DIPLOMA IV/ STRATA I', 'jumlah' => 166],
            ['kelompok' => 'STRATA II', 'jumlah' => 5],
            ['kelompok' => 'STRATA III', 'jumlah' => 1],
        ];

        foreach ($pendidikan as $p) {
            DB::table('pendidikans')->insert([
                'wilayah_id' => $desaId,
                'tingkat_pendidikan' => $p['kelompok'],
                'jumlah' => $p['jumlah'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // 2. DATA PEKERJAAN
        $pekerjaan = [
            ['kelompok' => 'BELUM/TIDAK BEKERJA', 'jumlah' => 1819],
            ['kelompok' => 'MENGURUS RUMAH TANGGA', 'jumlah' => 973],
            ['kelompok' => 'PELAJAR/MAHASISWA', 'jumlah' => 483],
            ['kelompok' => 'PENSIUNAN', 'jumlah' => 6],
            ['kelompok' => 'PEGAWAI NEGERI SIPIL (PNS)', 'jumlah' => 25],
            ['kelompok' => 'TENTARA NASIONAL INDONESIA (TNI)', 'jumlah' => 1],
            ['kelompok' => 'KEPOLISIAN RI (POLRI)', 'jumlah' => 1],
            ['kelompok' => 'PERDAGANGAN', 'jumlah' => 57],
            ['kelompok' => 'PETANI/PEKEBUN', 'jumlah' => 24],
            ['kelompok' => 'NELAYAN/PERIKANAN', 'jumlah' => 14],
            ['kelompok' => 'KARYAWAN SWASTA', 'jumlah' => 314],
            ['kelompok' => 'KARYAWAN BUMN', 'jumlah' => 1],
            ['kelompok' => 'KARYAWAN BUMD', 'jumlah' => 1],
            ['kelompok' => 'KARYAWAN HONORER', 'jumlah' => 8],
            ['kelompok' => 'BURUH HARIAN LEPAS', 'jumlah' => 29],
            ['kelompok' => 'BURUH TANI/PERKEBUNAN', 'jumlah' => 12],
            ['kelompok' => 'PEMBANTU RUMAH TANGGA', 'jumlah' => 3],
            ['kelompok' => 'TUKANG CUKUR', 'jumlah' => 1],
            ['kelompok' => 'TUKANG BATU', 'jumlah' => 2],
            ['kelompok' => 'TUKANG KAYU', 'jumlah' => 200],
            ['kelompok' => 'TUKANG JAHIT', 'jumlah' => 4],
            ['kelompok' => 'PENATA RIAS', 'jumlah' => 1],
            ['kelompok' => 'MEKANIK', 'jumlah' => 3],
            ['kelompok' => 'USTADZ/MUBALIGH', 'jumlah' => 3],
            ['kelompok' => 'GURU', 'jumlah' => 46],
            ['kelompok' => 'BIDAN', 'jumlah' => 1],
            ['kelompok' => 'PERAWAT', 'jumlah' => 2],
            ['kelompok' => 'APOTEKER', 'jumlah' => 1],
            ['kelompok' => 'PENYIAR TELEVISI', 'jumlah' => 1],
            ['kelompok' => 'PELAUT', 'jumlah' => 1],
            ['kelompok' => 'SOPIR', 'jumlah' => 10],
            ['kelompok' => 'PEDAGANG', 'jumlah' => 8],
            ['kelompok' => 'PERANGKAT DESA', 'jumlah' => 3],
            ['kelompok' => 'WIRASWASTA', 'jumlah' => 1410],
            ['kelompok' => 'LAINNYA', 'jumlah' => 5],
        ];

        foreach ($pekerjaan as $p) {
            DB::table('pekerjaans')->insert([
                'wilayah_id' => $desaId,
                'jenis_pekerjaan' => $p['kelompok'],
                'jumlah' => $p['jumlah'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // 3. DATA AGAMA
        $agama = [
            ['kelompok' => 'ISLAM', 'jumlah' => 5462],
            ['kelompok' => 'KRISTEN', 'jumlah' => 5],
            ['kelompok' => 'KATHOLIK', 'jumlah' => 3],
        ];

        foreach ($agama as $a) {
            DB::table('agamas')->insert([
                'wilayah_id' => $desaId,
                'agama' => $a['kelompok'],
                'jumlah' => $a['jumlah'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // 4. DATA UMUR
        $umur = [
            ['kelompok' => 'Di bawah 1 Tahun', 'jumlah' => 59],
            ['kelompok' => '2 s/d 4 Tahun', 'jumlah' => 177],
            ['kelompok' => '5 s/d 9 Tahun', 'jumlah' => 405],
            ['kelompok' => '10 s/d 14 Tahun', 'jumlah' => 403],
            ['kelompok' => '15 s/d 19 Tahun', 'jumlah' => 473],
            ['kelompok' => '20 s/d 24 Tahun', 'jumlah' => 457],
            ['kelompok' => '25 s/d 29 Tahun', 'jumlah' => 437],
            ['kelompok' => '30 s/d 34 Tahun', 'jumlah' => 397],
            ['kelompok' => '35 s/d 39 Tahun', 'jumlah' => 386],
            ['kelompok' => '40 s/d 44 Tahun', 'jumlah' => 448],
            ['kelompok' => '45 s/d 49 Tahun', 'jumlah' => 474],
            ['kelompok' => '50 s/d 54 Tahun', 'jumlah' => 387],
            ['kelompok' => '55 s/d 59 Tahun', 'jumlah' => 316],
            ['kelompok' => '60 s/d 64 Tahun', 'jumlah' => 247],
            ['kelompok' => '65 s/d 69 Tahun', 'jumlah' => 182],
            ['kelompok' => '70 s/d 74 Tahun', 'jumlah' => 93],
            ['kelompok' => '75 Tahun ke Atas', 'jumlah' => 124],
        ];

        foreach ($umur as $u) {
            DB::table('umurs')->insert([
                'wilayah_id' => $desaId,
                'rentang_umur' => $u['kelompok'],
                'jumlah' => $u['jumlah'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
