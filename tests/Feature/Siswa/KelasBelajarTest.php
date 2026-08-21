<?php

namespace Tests\Feature\Siswa;

use App\Models\KelasBelajar;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\MembuatDataDasar;
use Tests\TestCase;

class KelasBelajarTest extends TestCase
{
    use MembuatDataDasar, RefreshDatabase;

    public function test_siswa_dapat_bergabung_kelas_dengan_kode(): void
    {
        $guru = $this->buatGuru();
        $siswa = $this->buatSiswa();
        $kelas = KelasBelajar::factory()->for($guru, 'pengguna')->create([
            'id_mata_pelajaran' => $this->buatMataPelajaran()->id,
            'kode_kelas' => 'ETNO-TES01',
        ]);

        $this->actingAs($siswa)
            ->post(route('siswa.kelas.gabung'), ['kode_kelas' => 'etno-tes01'])
            ->assertRedirect(route('siswa.kelas.show', $kelas));

        $this->assertTrue($siswa->kelasDiikuti()->where('kelas_belajar.id', $kelas->id)->exists());
    }

    public function test_siswa_gagal_bergabung_dengan_kode_tidak_valid(): void
    {
        $siswa = $this->buatSiswa();

        $this->actingAs($siswa)
            ->post(route('siswa.kelas.gabung'), ['kode_kelas' => 'TIDAK-ADA'])
            ->assertSessionHasErrors('kode_kelas');
    }

    public function test_siswa_tidak_bisa_melihat_kelas_yang_belum_diikuti(): void
    {
        $guru = $this->buatGuru();
        $siswa = $this->buatSiswa();
        $kelas = KelasBelajar::factory()->for($guru, 'pengguna')->create([
            'id_mata_pelajaran' => $this->buatMataPelajaran()->id,
        ]);

        $this->actingAs($siswa)
            ->get(route('siswa.kelas.show', $kelas))
            ->assertForbidden();
    }
}
