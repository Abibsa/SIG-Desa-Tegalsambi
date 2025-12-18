<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WilayahSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('wilayahs')->truncate();

        // 1. Create Root: DESA TEGALSAMBI
        // Total data from document: KK=1673, L=2765, P=2710
        $desaId = DB::table('wilayahs')->insertGetId([
            'nama' => 'Desa Tegalsambi',
            'tingkat' => 'desa',
            'parent_id' => null,
            'kk' => 1673,
            'l' => 2765,
            'p' => 2710,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Data Hierarki (Dusun -> RW -> RT)
        $dataDusun = [
            'GEGUNUNG' => [
                'RW 002' => [
                    'RT 008' => ['kk' => 164, 'l' => 267, 'p' => 276],
                    'RT 006' => ['kk' => 132, 'l' => 231, 'p' => 197],
                    'RT 007' => ['kk' => 140, 'l' => 240, 'p' => 232],
                    'RT 012' => ['kk' => 70, 'l' => 115, 'p' => 106],
                ],
                'RW 001' => [
                    'RT 004' => ['kk' => 174, 'l' => 305, 'p' => 287],
                    'RT 005' => ['kk' => 176, 'l' => 313, 'p' => 311],
                ]
            ],
            'LEMBAH' => [
                'RW 001' => [
                    'RT 001' => ['kk' => 157, 'l' => 267, 'p' => 266],
                    'RT 002' => ['kk' => 100, 'l' => 146, 'p' => 148],
                    'RT 003' => ['kk' => 109, 'l' => 177, 'p' => 171],
                ],
                'RW 002' => [
                    'RT 009' => ['kk' => 186, 'l' => 283, 'p' => 284],
                    'RT 010' => ['kk' => 109, 'l' => 173, 'p' => 186],
                    'RT 011' => ['kk' => 156, 'l' => 248, 'p' => 246],
                ]
            ]
        ];

        foreach ($dataDusun as $namaDusun => $dataRw) {
            // 2. Create Dusun
            $dusunId = DB::table('wilayahs')->insertGetId([
                'nama' => 'Dusun ' . $namaDusun,
                'tingkat' => 'dusun',
                'parent_id' => $desaId,
                'kk' => 0,
                'l' => 0,
                'p' => 0, // Akan di-update
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $dusunKK = 0;
            $dusunL = 0;
            $dusunP = 0;

            foreach ($dataRw as $namaRw => $dataRt) {
                // 3. Create RW
                $rwId = DB::table('wilayahs')->insertGetId([
                    'nama' => $namaRw . ' (' . $namaDusun . ')',
                    'tingkat' => 'rw',
                    'parent_id' => $dusunId,
                    'kk' => 0,
                    'l' => 0,
                    'p' => 0, // Akan di-update
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $rwKK = 0;
                $rwL = 0;
                $rwP = 0;

                foreach ($dataRt as $namaRt => $stats) {
                    // 4. Create RT
                    DB::table('wilayahs')->insert([
                        'nama' => $namaRt,
                        'tingkat' => 'rt',
                        'parent_id' => $rwId,
                        'kk' => $stats['kk'],
                        'l' => $stats['l'],
                        'p' => $stats['p'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    $rwKK += $stats['kk'];
                    $rwL += $stats['l'];
                    $rwP += $stats['p'];
                }

                // Update RW Totals
                DB::table('wilayahs')->where('id', $rwId)->update([
                    'kk' => $rwKK,
                    'l' => $rwL,
                    'p' => $rwP
                ]);

                $dusunKK += $rwKK;
                $dusunL += $rwL;
                $dusunP += $rwP;
            }

            // Update Dusun Totals
            DB::table('wilayahs')->where('id', $dusunId)->update([
                'kk' => $dusunKK,
                'l' => $dusunL,
                'p' => $dusunP
            ]);
        }
    }
}
