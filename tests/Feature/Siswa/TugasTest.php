<?php

namespace Tests\Feature\Siswa;

use App\Models\KelasBelajar;
use App\Models\TugasKelas;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Concerns\MembuatDataDasar;
use Tests\TestCase;

class TugasTest extends TestCase
{
    use MembuatDataDasar, RefreshDatabase;

    public function test_siswa_dapat_mengumpulkan_tugas(): void
    {
        Storage::fake('public');

        $guru = $this->buatGuru();
        $siswa = $this->buatSiswa();
        $kelas = KelasBelajar::factory()->for($guru, 'pengguna')->create([
            'id_mata_pelajaran' => $this->buatMataPelajaran()->id,
        ]);
        $kelas->anggota()->attach($siswa->id, ['bergabung_pada' => now()]);

        $tugas = TugasKelas::create([
            'id_kelas_belajar' => $kelas->id,
            'id_pengguna' => $guru->id,
            'judul' => 'Laporan Observasi',
            'status' => 'dipublikasikan',
        ]);

        $this->actingAs($siswa)
            ->post(route('siswa.tugas.kumpul', $tugas), [
                'catatan_siswa' => 'Ini laporan saya.',
                'berkas' => UploadedFile::fake()->create('laporan.pdf', 100),
            ])
            ->assertRedirect(route('siswa.tugas.show', $tugas));

        $this->assertDatabaseHas('pengumpulan_tugas', [
            'id_tugas_kelas' => $tugas->id,
            'id_pengguna' => $siswa->id,
            'status' => 'dikirim',
        ]);
    }

    public function test_siswa_bukan_anggota_kelas_tidak_bisa_mengumpulkan_tugas(): void
    {
        $guru = $this->buatGuru();
        $siswa = $this->buatSiswa();
        $kelas = KelasBelajar::factory()->for($guru, 'pengguna')->create([
            'id_mata_pelajaran' => $this->buatMataPelajaran()->id,
        ]);

        $tugas = TugasKelas::create([
            'id_kelas_belajar' => $kelas->id,
            'id_pengguna' => $guru->id,
            'judul' => 'Laporan Observasi',
            'status' => 'dipublikasikan',
        ]);

        $this->actingAs($siswa)
            ->get(route('siswa.tugas.show', $tugas))
            ->assertForbidden();
    }
}
