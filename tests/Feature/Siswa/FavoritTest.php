<?php

namespace Tests\Feature\Siswa;

use App\Enums\StatusPublikasi;
use App\Models\EModul;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\MembuatDataDasar;
use Tests\TestCase;

class FavoritTest extends TestCase
{
    use MembuatDataDasar, RefreshDatabase;

    public function test_siswa_dapat_menambah_dan_menghapus_favorit(): void
    {
        $guru = $this->buatGuru();
        $siswa = $this->buatSiswa();
        $eModul = EModul::factory()->for($guru, 'pengguna')->create([
            'id_jenjang_pendidikan' => $this->buatJenjangPendidikan()->id,
            'id_mata_pelajaran' => $this->buatMataPelajaran()->id,
            'status_publikasi' => StatusPublikasi::Dipublikasikan,
        ]);

        $this->actingAs($siswa)->post(route('siswa.favorit.toggle'), [
            'jenis_konten' => 'e_modul',
            'id_referensi' => $eModul->id,
        ])->assertRedirect();

        $this->assertDatabaseHas('favorit', [
            'id_pengguna' => $siswa->id,
            'jenis_konten' => 'e_modul',
            'id_referensi' => $eModul->id,
        ]);

        // Toggle lagi -> harus terhapus
        $this->actingAs($siswa)->post(route('siswa.favorit.toggle'), [
            'jenis_konten' => 'e_modul',
            'id_referensi' => $eModul->id,
        ])->assertRedirect();

        $this->assertDatabaseMissing('favorit', [
            'id_pengguna' => $siswa->id,
            'jenis_konten' => 'e_modul',
            'id_referensi' => $eModul->id,
        ]);
    }
}
