<?php

namespace Database\Seeders;

use App\Models\Peran;
use Illuminate\Database\Seeder;

class PeranSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            ['nama_peran' => 'administrator', 'keterangan' => 'Pengelola penuh sistem E-ETNOSAINS'],
            ['nama_peran' => 'guru', 'keterangan' => 'Penyusun dan pengelola konten pembelajaran'],
            ['nama_peran' => 'siswa', 'keterangan' => 'Pengguna pembelajar konten E-ETNOSAINS'],
        ] as $peran) {
            Peran::query()->updateOrCreate(['nama_peran' => $peran['nama_peran']], $peran);
        }
    }
}
