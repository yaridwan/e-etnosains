<?php

namespace Tests\Feature\Admin;

use App\Enums\StatusPublikasi;
use App\Models\EModul;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\MembuatDataDasar;
use Tests\TestCase;

class EModulReviewTest extends TestCase
{
    use MembuatDataDasar, RefreshDatabase;

    public function test_administrator_dapat_menyetujui_e_modul_yang_diajukan(): void
    {
        $admin = $this->buatAdmin();
        $guru = $this->buatGuru();
        $eModul = EModul::factory()->for($guru, 'pengguna')->create([
            'id_jenjang_pendidikan' => $this->buatJenjangPendidikan()->id,
            'id_mata_pelajaran' => $this->buatMataPelajaran()->id,
            'status_publikasi' => StatusPublikasi::Diajukan,
        ]);

        $this->actingAs($admin)
            ->post(route('admin.tinjau-e-modul.setujui', $eModul), ['catatan' => 'Sudah baik.'])
            ->assertRedirect(route('admin.tinjau-e-modul.index'));

        $eModul->refresh();
        $this->assertSame(StatusPublikasi::Dipublikasikan, $eModul->status_publikasi);
        $this->assertNotNull($eModul->dipublikasikan_pada);
        $this->assertDatabaseHas('riwayat_status_e_modul', [
            'id_e_modul' => $eModul->id,
            'status_sesudah' => 'dipublikasikan',
        ]);
    }

    public function test_administrator_dapat_meminta_perbaikan_e_modul(): void
    {
        $admin = $this->buatAdmin();
        $guru = $this->buatGuru();
        $eModul = EModul::factory()->for($guru, 'pengguna')->create([
            'id_jenjang_pendidikan' => $this->buatJenjangPendidikan()->id,
            'id_mata_pelajaran' => $this->buatMataPelajaran()->id,
            'status_publikasi' => StatusPublikasi::Diajukan,
        ]);

        $this->actingAs($admin)
            ->post(route('admin.tinjau-e-modul.minta-perbaikan', $eModul), ['catatan' => 'Lengkapi bagian evaluasi.'])
            ->assertRedirect();

        $this->assertSame(StatusPublikasi::PerluPerbaikan, $eModul->fresh()->status_publikasi);
    }

    public function test_e_modul_draf_tidak_muncul_di_halaman_publik(): void
    {
        $guru = $this->buatGuru();
        $eModul = EModul::factory()->for($guru, 'pengguna')->create([
            'id_jenjang_pendidikan' => $this->buatJenjangPendidikan()->id,
            'id_mata_pelajaran' => $this->buatMataPelajaran()->id,
            'status_publikasi' => StatusPublikasi::Draf,
        ]);

        $this->get(route('e-modul.show', $eModul))->assertNotFound();
    }

    public function test_menyetujui_e_modul_membekukan_versi_baru(): void
    {
        $admin = $this->buatAdmin();
        $guru = $this->buatGuru();
        $eModul = EModul::factory()->for($guru, 'pengguna')->create([
            'id_jenjang_pendidikan' => $this->buatJenjangPendidikan()->id,
            'id_mata_pelajaran' => $this->buatMataPelajaran()->id,
            'status_publikasi' => StatusPublikasi::Diajukan,
            'judul' => 'Kearifan Lokal Nelayan',
        ]);

        $this->actingAs($admin)->post(route('admin.tinjau-e-modul.setujui', $eModul), ['catatan' => 'Baik.']);

        $this->assertDatabaseHas('versi_e_modul', [
            'id_e_modul' => $eModul->id,
            'nomor_versi' => 1,
            'judul' => 'Kearifan Lokal Nelayan',
            'id_pengguna' => $admin->id,
        ]);
    }

    public function test_administrator_dapat_menjadwalkan_terbit_e_modul(): void
    {
        $admin = $this->buatAdmin();
        $guru = $this->buatGuru();
        $eModul = EModul::factory()->for($guru, 'pengguna')->create([
            'id_jenjang_pendidikan' => $this->buatJenjangPendidikan()->id,
            'id_mata_pelajaran' => $this->buatMataPelajaran()->id,
            'status_publikasi' => StatusPublikasi::Diajukan,
            'dipublikasikan_pada' => null,
        ]);

        $waktuTerbit = now()->addDays(3)->format('Y-m-d\TH:i');

        $this->actingAs($admin)
            ->post(route('admin.tinjau-e-modul.setujui', $eModul), ['terbitkan_pada' => $waktuTerbit])
            ->assertRedirect(route('admin.tinjau-e-modul.index'));

        $eModul->refresh();
        $this->assertSame(StatusPublikasi::Dijadwalkan, $eModul->status_publikasi);
        $this->assertNotNull($eModul->dijadwalkan_pada);
        $this->assertNull($eModul->dipublikasikan_pada);

        // Belum terbit di publik selama masih berstatus dijadwalkan.
        $this->get(route('e-modul.show', $eModul))->assertNotFound();

        // Belum ada versi yang dibekukan karena belum benar-benar terbit.
        $this->assertDatabaseCount('versi_e_modul', 0);
    }

    public function test_perintah_terjadwal_menerbitkan_e_modul_yang_sudah_jatuh_tempo(): void
    {
        $guru = $this->buatGuru();
        $eModulJatuhTempo = EModul::factory()->for($guru, 'pengguna')->create([
            'id_jenjang_pendidikan' => $this->buatJenjangPendidikan()->id,
            'id_mata_pelajaran' => $this->buatMataPelajaran()->id,
            'status_publikasi' => StatusPublikasi::Dijadwalkan,
            'dijadwalkan_pada' => now()->subMinute(),
        ]);
        $eModulBelumWaktunya = EModul::factory()->for($guru, 'pengguna')->create([
            'id_jenjang_pendidikan' => $this->buatJenjangPendidikan()->id,
            'id_mata_pelajaran' => $this->buatMataPelajaran()->id,
            'status_publikasi' => StatusPublikasi::Dijadwalkan,
            'dijadwalkan_pada' => now()->addDay(),
        ]);

        $this->artisan('e-modul:terbitkan-terjadwal')->assertSuccessful();

        $this->assertSame(StatusPublikasi::Dipublikasikan, $eModulJatuhTempo->fresh()->status_publikasi);
        $this->assertNotNull($eModulJatuhTempo->fresh()->dipublikasikan_pada);
        $this->assertDatabaseHas('versi_e_modul', ['id_e_modul' => $eModulJatuhTempo->id, 'nomor_versi' => 1]);

        $this->assertSame(StatusPublikasi::Dijadwalkan, $eModulBelumWaktunya->fresh()->status_publikasi);
    }

    public function test_pencarian_judul_pada_tinjau_e_modul(): void
    {
        $admin = $this->buatAdmin();
        $guru = $this->buatGuru();
        EModul::factory()->for($guru, 'pengguna')->create([
            'id_jenjang_pendidikan' => $this->buatJenjangPendidikan()->id,
            'id_mata_pelajaran' => $this->buatMataPelajaran()->id,
            'status_publikasi' => StatusPublikasi::Diajukan,
            'judul' => 'Sains dalam Kerajinan Anyaman Bambu',
        ]);
        EModul::factory()->for($guru, 'pengguna')->create([
            'id_jenjang_pendidikan' => $this->buatJenjangPendidikan()->id,
            'id_mata_pelajaran' => $this->buatMataPelajaran()->id,
            'status_publikasi' => StatusPublikasi::Diajukan,
            'judul' => 'Konservasi Air Tradisional',
        ]);

        $respons = $this->actingAs($admin)->get(route('admin.tinjau-e-modul.index', ['q' => 'Anyaman Bambu']));

        $respons->assertOk()->assertSee('Sains dalam Kerajinan Anyaman Bambu')->assertDontSee('Konservasi Air Tradisional');
    }

    public function test_daftar_tinjau_e_modul_tanpa_filter_menyembunyikan_draf_dan_ditolak(): void
    {
        $admin = $this->buatAdmin();
        $guru = $this->buatGuru();
        EModul::factory()->for($guru, 'pengguna')->create([
            'id_jenjang_pendidikan' => $this->buatJenjangPendidikan()->id,
            'id_mata_pelajaran' => $this->buatMataPelajaran()->id,
            'status_publikasi' => StatusPublikasi::Draf,
            'judul' => 'E-Modul Masih Draf',
        ]);
        EModul::factory()->for($guru, 'pengguna')->create([
            'id_jenjang_pendidikan' => $this->buatJenjangPendidikan()->id,
            'id_mata_pelajaran' => $this->buatMataPelajaran()->id,
            'status_publikasi' => StatusPublikasi::Diajukan,
            'judul' => 'E-Modul Diajukan',
        ]);

        $respons = $this->actingAs($admin)->get(route('admin.tinjau-e-modul.index'));

        $respons->assertOk()->assertSee('E-Modul Diajukan')->assertDontSee('E-Modul Masih Draf');
    }

    public function test_filter_tampil_semua_menampilkan_e_modul_draf_dan_ditolak(): void
    {
        $admin = $this->buatAdmin();
        $guru = $this->buatGuru();
        EModul::factory()->for($guru, 'pengguna')->create([
            'id_jenjang_pendidikan' => $this->buatJenjangPendidikan()->id,
            'id_mata_pelajaran' => $this->buatMataPelajaran()->id,
            'status_publikasi' => StatusPublikasi::Draf,
            'judul' => 'E-Modul Masih Draf',
        ]);
        EModul::factory()->for($guru, 'pengguna')->create([
            'id_jenjang_pendidikan' => $this->buatJenjangPendidikan()->id,
            'id_mata_pelajaran' => $this->buatMataPelajaran()->id,
            'status_publikasi' => StatusPublikasi::Ditolak,
            'judul' => 'E-Modul Ditolak',
        ]);

        $respons = $this->actingAs($admin)->get(route('admin.tinjau-e-modul.index', ['status' => 'semua']));

        $respons->assertOk()->assertSee('E-Modul Masih Draf')->assertSee('E-Modul Ditolak');
    }

    public function test_administrator_dapat_membatalkan_penjadwalan_terbit(): void
    {
        $admin = $this->buatAdmin();
        $guru = $this->buatGuru();
        $eModul = EModul::factory()->for($guru, 'pengguna')->create([
            'id_jenjang_pendidikan' => $this->buatJenjangPendidikan()->id,
            'id_mata_pelajaran' => $this->buatMataPelajaran()->id,
            'status_publikasi' => StatusPublikasi::Dijadwalkan,
            'dijadwalkan_pada' => now()->addDays(2),
        ]);

        $this->actingAs($admin)
            ->post(route('admin.tinjau-e-modul.batalkan-jadwal', $eModul))
            ->assertRedirect();

        $eModul->refresh();
        $this->assertSame(StatusPublikasi::Disetujui, $eModul->status_publikasi);
        $this->assertNull($eModul->dijadwalkan_pada);
    }
}
