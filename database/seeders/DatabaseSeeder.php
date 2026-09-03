<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            // Sistem & RBAC
            PeranSeeder::class,
            IzinSeeder::class,
            PeranIzinSeeder::class,
            PengaturanAplikasiSeeder::class,

            // Master data
            InstansiPendidikanSeeder::class,
            JenjangPendidikanSeeder::class,
            MataPelajaranSeeder::class,
            KategoriKontenSeeder::class,
            TopikEtnosainsSeeder::class,
            DaerahEtnosainsSeeder::class,
            TagSeeder::class,

            // Pengguna
            PenggunaSeeder::class,

            // Konten pembelajaran
            EModulSeeder::class,
            LkpdSeeder::class,
            BahanAjarSeeder::class,
            VideoPembelajaranSeeder::class,
            PosterSeeder::class,
            ObservasiSeeder::class,
            EvaluasiSeeder::class,
            KontenTagSeeder::class,

            // Kelas & pembelajaran
            KelasBelajarSeeder::class,
            TugasKelasSeeder::class,
            PengumpulanObservasiSeeder::class,

            // Aktivitas & interaksi
            KemajuanBelajarSeeder::class,
            FavoritSeeder::class,
            UlasanSeeder::class,
            AktivitasLogSeeder::class,
            NotifikasiSeeder::class,

            // Website publik
            FaqSeeder::class,
            TestimoniSeeder::class,
            HalamanStatisSeeder::class,
            MenuNavigasiSeeder::class,
            BannerSeeder::class,
            PengumumanSeeder::class,
        ]);
    }
}
