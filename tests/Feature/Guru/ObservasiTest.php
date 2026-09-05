<?php

namespace Tests\Feature\Guru;

use App\Models\Observasi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\MembuatDataDasar;
use Tests\TestCase;

class ObservasiTest extends TestCase
{
    use MembuatDataDasar, RefreshDatabase;

    public function test_guru_dapat_membuat_observasi_dengan_butir_pertanyaan(): void
    {
        $guru = $this->buatGuru();

        $this->actingAs($guru)
            ->post(route('guru.observasi.store'), [
                'judul' => 'Observasi Pengolahan Gula Aren',
                'butir' => [
                    ['pertanyaan' => 'Apa warna larutan?', 'tipe_pertanyaan' => 'teks_pendek', 'wajib' => true],
                    ['pertanyaan' => 'Pilih metode', 'tipe_pertanyaan' => 'pilihan_tunggal', 'opsi_teks' => "Rebus\nKukus"],
                ],
            ])
            ->assertRedirect(route('guru.observasi.index'));

        $observasi = Observasi::where('judul', 'Observasi Pengolahan Gula Aren')->firstOrFail();
        $this->assertSame(2, $observasi->butirObservasi()->count());

        $butirPilihan = $observasi->butirObservasi()->where('tipe_pertanyaan', 'pilihan_tunggal')->firstOrFail();
        $this->assertSame(2, $butirPilihan->opsi()->count());
    }

    public function test_guru_dapat_memperbarui_observasi_dengan_butir_pertanyaan(): void
    {
        $guru = $this->buatGuru();
        $observasi = Observasi::factory()->for($guru, 'pengguna')->create();

        $this->actingAs($guru)
            ->put(route('guru.observasi.update', $observasi), [
                'judul' => $observasi->judul,
                'butir' => [
                    ['pertanyaan' => 'Berapa suhu larutan?', 'tipe_pertanyaan' => 'angka', 'wajib' => false],
                ],
            ])
            ->assertRedirect();

        $this->assertSame(1, $observasi->butirObservasi()->count());
    }
}
