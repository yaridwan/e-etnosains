<?php

namespace Database\Seeders;

use App\Models\MenuNavigasi;
use Illuminate\Database\Seeder;

class MenuNavigasiSeeder extends Seeder
{
    public function run(): void
    {
        $menu = [
            ['label' => 'Beranda', 'tautan' => '/', 'urutan' => 1],
            ['label' => 'E-Modul', 'tautan' => '/e-modul', 'urutan' => 2],
            ['label' => 'LKPD', 'tautan' => '/lkpd', 'urutan' => 3],
            ['label' => 'Bahan Ajar', 'tautan' => '/bahan-ajar', 'urutan' => 4],
            ['label' => 'Observasi', 'tautan' => '/observasi', 'urutan' => 5],
            ['label' => 'Video', 'tautan' => '/video', 'urutan' => 6],
            ['label' => 'Topik Etnosains', 'tautan' => '/topik-etnosains', 'urutan' => 7],
            ['label' => 'Tentang', 'tautan' => '/tentang', 'urutan' => 8],
            ['label' => 'FAQ', 'tautan' => '/faq', 'urutan' => 9],
        ];

        foreach ($menu as $data) {
            MenuNavigasi::query()->updateOrCreate(['label' => $data['label']], $data + ['aktif' => true]);
        }
    }
}
