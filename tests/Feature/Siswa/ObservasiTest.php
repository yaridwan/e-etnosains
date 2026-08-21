<?php

namespace Tests\Feature\Siswa;

use App\Enums\JenisPertanyaan;
use App\Enums\StatusPublikasi;
use App\Models\ButirObservasi;
use App\Models\Observasi;
use App\Models\PengumpulanObservasi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\MembuatDataDasar;
use Tests\TestCase;

class ObservasiTest extends TestCase
{
    use MembuatDataDasar, RefreshDatabase;

    public function test_siswa_dapat_mengirim_hasil_observasi(): void
    {
        $guru = $this->buatGuru();
        $siswa = $this->buatSiswa();

        $observasi = Observasi::factory()->for($guru, 'pengguna')->create([
            'status_publikasi' => StatusPublikasi::Dipublikasikan,
        ]);

        $butir = ButirObservasi::create([
            'id_observasi' => $observasi->id,
            'pertanyaan' => 'Apa hasil pengamatan Anda?',
            'tipe_pertanyaan' => JenisPertanyaan::TeksPanjang,
            'wajib' => true,
            'urutan' => 1,
        ]);

        $this->actingAs($siswa)
            ->post(route('siswa.observasi.kirim', $observasi), [
                'jawaban' => [$butir->id => 'Hasil pengamatan saya adalah ...'],
            ])
            ->assertRedirect(route('siswa.observasi.index'));

        $this->assertDatabaseHas('pengumpulan_observasi', [
            'id_observasi' => $observasi->id,
            'id_pengguna' => $siswa->id,
            'status' => 'dikirim',
        ]);

        $this->assertDatabaseHas('jawaban_observasi', [
            'id_butir_observasi' => $butir->id,
            'jawaban_teks' => 'Hasil pengamatan saya adalah ...',
        ]);
    }

    public function test_guru_dapat_menilai_pengumpulan_observasi_siswa(): void
    {
        $guru = $this->buatGuru();
        $siswa = $this->buatSiswa();
        $observasi = Observasi::factory()->for($guru, 'pengguna')->create();

        $pengumpulan = PengumpulanObservasi::create([
            'id_observasi' => $observasi->id,
            'id_pengguna' => $siswa->id,
            'status' => 'dikirim',
            'dikirim_pada' => now(),
        ]);

        $this->actingAs($guru)
            ->post(route('guru.pengumpulan-observasi.nilai', $pengumpulan), [
                'skor' => 90,
                'catatan_guru' => 'Kerja bagus.',
            ])
            ->assertRedirect();

        $pengumpulan->refresh();
        $this->assertSame('dinilai', $pengumpulan->status);
        $this->assertSame(90, $pengumpulan->skor);
    }
}
