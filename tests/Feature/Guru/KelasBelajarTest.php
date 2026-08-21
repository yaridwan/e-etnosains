<?php

namespace Tests\Feature\Guru;

use App\Models\KelasBelajar;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\MembuatDataDasar;
use Tests\TestCase;

class KelasBelajarTest extends TestCase
{
    use MembuatDataDasar, RefreshDatabase;

    public function test_guru_dapat_membuat_kelas_belajar(): void
    {
        $guru = $this->buatGuru();
        $mapel = $this->buatMataPelajaran();

        $respons = $this->actingAs($guru)->post(route('guru.kelas.store'), [
            'nama_kelas' => 'BIOLOGI X-A',
            'id_mata_pelajaran' => $mapel->id,
            'tahun_ajaran' => '2026/2027',
        ]);

        $this->assertDatabaseHas('kelas_belajar', [
            'nama_kelas' => 'BIOLOGI X-A',
            'id_pengguna' => $guru->id,
        ]);

        $kelas = KelasBelajar::where('nama_kelas', 'BIOLOGI X-A')->firstOrFail();
        $respons->assertRedirect(route('guru.kelas.show', $kelas));
        $this->assertNotEmpty($kelas->kode_kelas);
    }
}
