<?php

namespace Database\Seeders;

use App\Models\InstansiPendidikan;
use Illuminate\Database\Seeder;

class InstansiPendidikanSeeder extends Seeder
{
    public function run(): void
    {
        $instansi = [
            ['nama_instansi' => 'SMA Negeri 1 Yogyakarta', 'jenis_instansi' => 'SMA/MA', 'kota' => 'Yogyakarta', 'provinsi' => 'D.I. Yogyakarta'],
            ['nama_instansi' => 'SMP Negeri 3 Surakarta', 'jenis_instansi' => 'SMP/MTs', 'kota' => 'Surakarta', 'provinsi' => 'Jawa Tengah'],
            ['nama_instansi' => 'SMA Negeri 5 Malang', 'jenis_instansi' => 'SMA/MA', 'kota' => 'Malang', 'provinsi' => 'Jawa Timur'],
            ['nama_instansi' => 'SMK Negeri 2 Padang', 'jenis_instansi' => 'SMK', 'kota' => 'Padang', 'provinsi' => 'Sumatera Barat'],
            ['nama_instansi' => 'SD Negeri 1 Denpasar', 'jenis_instansi' => 'SD/MI', 'kota' => 'Denpasar', 'provinsi' => 'Bali'],
            ['nama_instansi' => 'Universitas Pendidikan Nusantara', 'jenis_instansi' => 'Perguruan Tinggi', 'kota' => 'Bandung', 'provinsi' => 'Jawa Barat'],
            ['nama_instansi' => 'Umum / Tidak Terikat Instansi', 'jenis_instansi' => 'Umum'],
        ];

        foreach ($instansi as $data) {
            InstansiPendidikan::query()->updateOrCreate(['nama_instansi' => $data['nama_instansi']], $data);
        }
    }
}
