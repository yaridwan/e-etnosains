<?php

namespace Database\Seeders;

use App\Models\MenuNavigasi;
use Illuminate\Database\Seeder;

class MenuNavigasiSeeder extends Seeder
{
    public function run(): void
    {
        // Menu tingkat atas dibuat ringkas; seluruh katalog konten dikelompokkan
        // ke dalam submenu "Jelajahi" agar bilah navigasi tidak sesak dan
        // labelnya tidak patah menjadi dua baris.
        $struktur = [
            ['label' => 'Beranda', 'tautan' => '/', 'urutan' => 1],
            [
                'label' => 'Jelajahi',
                'tautan' => '/e-modul',
                'urutan' => 2,
                'anak' => [
                    ['label' => 'E-Modul', 'tautan' => '/e-modul', 'urutan' => 1],
                    ['label' => 'LKPD', 'tautan' => '/lkpd', 'urutan' => 2],
                    ['label' => 'Bahan Ajar', 'tautan' => '/bahan-ajar', 'urutan' => 3],
                    ['label' => 'Video', 'tautan' => '/video', 'urutan' => 4],
                    ['label' => 'Poster', 'tautan' => '/poster', 'urutan' => 5],
                    ['label' => 'Observasi', 'tautan' => '/observasi', 'urutan' => 6],
                    ['label' => 'Evaluasi', 'tautan' => '/evaluasi', 'urutan' => 7],
                    ['label' => 'Topik Etnosains', 'tautan' => '/topik-etnosains', 'urutan' => 8],
                ],
            ],
            ['label' => 'Tentang', 'tautan' => '/halaman/tentang', 'urutan' => 3],
            ['label' => 'FAQ', 'tautan' => '/halaman/panduan', 'urutan' => 4],
        ];

        foreach ($struktur as $item) {
            $anak = $item['anak'] ?? [];
            unset($item['anak']);

            $induk = MenuNavigasi::query()->updateOrCreate(
                ['label' => $item['label'], 'induk_id' => null],
                $item + ['aktif' => true]
            );

            foreach ($anak as $submenu) {
                MenuNavigasi::query()->updateOrCreate(
                    ['label' => $submenu['label'], 'induk_id' => $induk->id],
                    $submenu + ['induk_id' => $induk->id, 'aktif' => true]
                );
            }
        }
    }
}
