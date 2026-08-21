<?php

namespace Tests\Feature;

use App\Enums\StatusPublikasi;
use App\Models\EModul;
use App\Models\Notifikasi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\MembuatDataDasar;
use Tests\TestCase;

class NotifikasiTest extends TestCase
{
    use MembuatDataDasar, RefreshDatabase;

    public function test_guru_menerima_notifikasi_saat_akun_disetujui(): void
    {
        $admin = $this->buatAdmin();
        $guru = $this->buatGuru(terverifikasi: false);

        $this->actingAs($admin)
            ->post(route('admin.verifikasi-guru.setujui', $guru->verifikasiGuru))
            ->assertRedirect();

        $this->assertDatabaseHas('notifikasi', [
            'id_pengguna' => $guru->id,
            'tipe' => 'verifikasi_guru',
            'judul' => 'Akun Anda Telah Disetujui',
        ]);
    }

    public function test_guru_menerima_notifikasi_saat_e_modul_dipublikasikan(): void
    {
        $admin = $this->buatAdmin();
        $guru = $this->buatGuru();
        $eModul = EModul::factory()->for($guru, 'pengguna')->create([
            'id_jenjang_pendidikan' => $this->buatJenjangPendidikan()->id,
            'id_mata_pelajaran' => $this->buatMataPelajaran()->id,
            'status_publikasi' => StatusPublikasi::Diajukan,
        ]);

        $this->actingAs($admin)
            ->post(route('admin.tinjau-e-modul.setujui', $eModul))
            ->assertRedirect();

        $this->assertDatabaseHas('notifikasi', [
            'id_pengguna' => $guru->id,
            'tipe' => 'e_modul',
            'judul' => 'E-Modul Anda Dipublikasikan',
        ]);
    }

    public function test_pengguna_dapat_menandai_notifikasi_telah_dibaca(): void
    {
        $siswa = $this->buatSiswa();

        $notifikasi = Notifikasi::create([
            'id_pengguna' => $siswa->id,
            'tipe' => 'umum',
            'judul' => 'Pemberitahuan Uji',
            'pesan' => 'Isi pemberitahuan uji.',
        ]);

        $this->actingAs($siswa)
            ->post(route('notifikasi.tandai-dibaca', $notifikasi))
            ->assertRedirect();

        $this->assertNotNull($notifikasi->fresh()->dibaca_pada);
    }

    public function test_pengguna_tidak_dapat_menandai_notifikasi_milik_orang_lain(): void
    {
        $siswaA = $this->buatSiswa();
        $siswaB = $this->buatSiswa();

        $notifikasi = Notifikasi::create([
            'id_pengguna' => $siswaA->id,
            'tipe' => 'umum',
            'judul' => 'Pemberitahuan Milik Orang Lain',
            'pesan' => 'Isi pemberitahuan.',
        ]);

        $this->actingAs($siswaB)
            ->post(route('notifikasi.tandai-dibaca', $notifikasi))
            ->assertForbidden();

        $this->assertNull($notifikasi->fresh()->dibaca_pada);
    }
}
