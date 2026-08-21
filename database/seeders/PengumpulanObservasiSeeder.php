<?php

namespace Database\Seeders;

use App\Models\DokumentasiObservasi;
use App\Models\JawabanObservasi;
use App\Models\Observasi;
use App\Models\PengumpulanObservasi;
use App\Models\Peran;
use App\Support\PembuatPosterDemo;
use Illuminate\Database\Seeder;

class PengumpulanObservasiSeeder extends Seeder
{
    public function run(): void
    {
        $siswa = Peran::where('nama_peran', 'siswa')->firstOrFail()->pengguna;

        Observasi::with('butirObservasi.opsi')->get()->each(function (Observasi $observasi) use ($siswa) {
            foreach ($siswa->take(3) as $murid) {
                $pengumpulan = PengumpulanObservasi::create([
                    'id_observasi' => $observasi->id,
                    'id_pengguna' => $murid->id,
                    'status' => 'dikirim',
                    'dikirim_pada' => now()->subDays(fake()->numberBetween(1, 10)),
                ]);

                foreach ($observasi->butirObservasi as $butir) {
                    JawabanObservasi::create([
                        'id_pengumpulan_observasi' => $pengumpulan->id,
                        'id_butir_observasi' => $butir->id,
                        'jawaban_teks' => in_array($butir->tipe_pertanyaan->value, ['teks_pendek', 'teks_panjang', 'ya_tidak'])
                            ? fake()->randomElement([
                                'Berdasarkan pengamatan saya, prosesnya berlangsung bertahap dan memerlukan waktu cukup lama.',
                                'Saya menemukan hubungan yang jelas antara praktik tradisional tersebut dengan konsep sains di kelas.',
                                'Masyarakat sekitar masih rutin melakukannya dan mewariskannya kepada generasi berikutnya.',
                                'Ya, kegiatan ini masih dipraktikkan hingga sekarang di lingkungan tempat tinggal saya.',
                            ])
                            : null,
                        'jawaban_angka' => $butir->tipe_pertanyaan->value === 'angka' ? fake()->numberBetween(20, 100) : null,
                        'id_opsi_butir_observasi' => $butir->opsi->isNotEmpty() ? $butir->opsi->random()->id : null,
                    ]);
                }

                DokumentasiObservasi::create([
                    'id_pengumpulan_observasi' => $pengumpulan->id,
                    'berkas' => PembuatPosterDemo::buat('Dokumentasi: '.$observasi->judul, 'observasi/dokumentasi'),
                    'keterangan' => 'Dokumentasi kegiatan observasi lapangan.',
                ]);
            }
        });

        // Beri nilai pada sebagian pengumpulan agar ada contoh yang sudah dinilai
        PengumpulanObservasi::with('observasi')->inRandomOrder()->take(5)->get()->each(function (PengumpulanObservasi $pengumpulan) {
            $pengumpulan->update([
                'status' => 'dinilai',
                'skor' => fake()->numberBetween(70, 100),
                'catatan_guru' => 'Observasi dilakukan dengan baik dan lengkap.',
                'dinilai_oleh' => $pengumpulan->observasi->id_pengguna,
                'dinilai_pada' => now()->subDay(),
            ]);
        });
    }
}
