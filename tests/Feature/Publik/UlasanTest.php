<?php

namespace Tests\Feature\Publik;

use App\Enums\StatusPublikasi;
use App\Models\EModul;
use App\Models\Ulasan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\MembuatDataDasar;
use Tests\TestCase;

class UlasanTest extends TestCase
{
    use MembuatDataDasar, RefreshDatabase;

    private function buatEModul(int $idPenulis): EModul
    {
        return EModul::factory()->create([
            'id_pengguna' => $idPenulis,
            'id_jenjang_pendidikan' => $this->buatJenjangPendidikan()->id,
            'id_mata_pelajaran' => $this->buatMataPelajaran()->id,
            'status_publikasi' => StatusPublikasi::Dipublikasikan,
        ]);
    }

    public function test_siswa_dapat_mengirim_ulasan_dan_berstatus_menunggu_moderasi(): void
    {
        $guru = $this->buatGuru();
        $siswa = $this->buatSiswa();
        $eModul = $this->buatEModul($guru->id);

        $this->actingAs($siswa)
            ->post(route('e-modul.ulasan.simpan', $eModul), [
                'rating' => 5,
                'komentar' => 'Materinya sangat membantu.',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('ulasan', [
            'id_pengguna' => $siswa->id,
            'jenis_konten' => 'e_modul',
            'id_referensi' => $eModul->id,
            'rating' => 5,
            'status_moderasi' => 'menunggu',
        ]);
    }

    public function test_guru_tidak_dapat_mengulas_kontennya_sendiri(): void
    {
        $guru = $this->buatGuru();
        $eModul = $this->buatEModul($guru->id);

        $this->actingAs($guru)
            ->post(route('e-modul.ulasan.simpan', $eModul), ['rating' => 5])
            ->assertForbidden();
    }

    public function test_ulasan_menunggu_moderasi_tidak_tampil_publik(): void
    {
        $guru = $this->buatGuru();
        $siswa = $this->buatSiswa();
        $eModul = $this->buatEModul($guru->id);

        Ulasan::create([
            'id_pengguna' => $siswa->id,
            'jenis_konten' => 'e_modul',
            'id_referensi' => $eModul->id,
            'rating' => 1,
            'komentar' => 'Komentar belum dimoderasi.',
            'status_moderasi' => 'menunggu',
        ]);

        $this->get(route('e-modul.show', $eModul))
            ->assertOk()
            ->assertDontSee('Komentar belum dimoderasi.');
    }

    public function test_administrator_dapat_menyetujui_ulasan_sehingga_tampil_publik(): void
    {
        $admin = $this->buatAdmin();
        $guru = $this->buatGuru();
        $siswa = $this->buatSiswa();
        $eModul = $this->buatEModul($guru->id);

        $ulasan = Ulasan::create([
            'id_pengguna' => $siswa->id,
            'jenis_konten' => 'e_modul',
            'id_referensi' => $eModul->id,
            'rating' => 5,
            'komentar' => 'Ulasan sudah disetujui.',
            'status_moderasi' => 'menunggu',
        ]);

        $this->actingAs($admin)
            ->post(route('admin.moderasi-ulasan.setujui', $ulasan))
            ->assertRedirect();

        $this->assertSame('disetujui', $ulasan->fresh()->status_moderasi);

        $this->get(route('e-modul.show', $eModul))
            ->assertOk()
            ->assertSee('Ulasan sudah disetujui.');
    }
}
