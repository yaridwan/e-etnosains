<?php

namespace Database\Seeders;

use App\Models\Izin;
use App\Models\Peran;
use Illuminate\Database\Seeder;

class PeranIzinSeeder extends Seeder
{
    public function run(): void
    {
        $administrator = Peran::where('nama_peran', 'administrator')->firstOrFail();
        $guru = Peran::where('nama_peran', 'guru')->firstOrFail();

        $administrator->izin()->sync(Izin::pluck('id'));

        $guru->izin()->sync(
            Izin::whereIn('nama_izin', [
                'kelola-e-modul', 'kelola-lkpd', 'kelola-bahan-ajar',
                'kelola-video', 'kelola-poster', 'kelola-observasi',
                'kelola-kelas-belajar', 'kelola-tugas',
            ])->pluck('id')
        );
    }
}
