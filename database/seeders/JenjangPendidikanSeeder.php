<?php

namespace Database\Seeders;

use App\Models\JenjangPendidikan;
use Illuminate\Database\Seeder;

class JenjangPendidikanSeeder extends Seeder
{
    public function run(): void
    {
        $jenjang = [
            'sd-mi' => 'SD/MI',
            'smp-mts' => 'SMP/MTs',
            'sma-ma' => 'SMA/MA',
            'smk' => 'SMK',
            'perguruan-tinggi' => 'Perguruan Tinggi',
        ];

        foreach (array_values($jenjang) as $urutan => $nama) {
            $slug = array_search($nama, $jenjang);

            JenjangPendidikan::query()->updateOrCreate(
                ['alamat_tautan' => $slug],
                ['nama_jenjang' => $nama, 'urutan' => $urutan]
            );
        }
    }
}
