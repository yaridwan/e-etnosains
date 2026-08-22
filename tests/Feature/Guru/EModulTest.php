<?php

namespace Tests\Feature\Guru;

use App\Enums\StatusPublikasi;
use App\Models\EModul;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Concerns\MembuatDataDasar;
use Tests\TestCase;

class EModulTest extends TestCase
{
    use MembuatDataDasar, RefreshDatabase;

    public function test_guru_dapat_membuat_e_modul_sebagai_draf(): void
    {
        Storage::fake('public');
        $guru = $this->buatGuru();
        $jenjang = $this->buatJenjangPendidikan();
        $mapel = $this->buatMataPelajaran();

        $respons = $this->actingAs($guru)->post(route('guru.e-modul.store'), [
            'judul' => 'Sains dalam Pembuatan Tempe',
            'id_jenjang_pendidikan' => $jenjang->id,
            'id_mata_pelajaran' => $mapel->id,
            'ringkasan' => 'Ringkasan materi bioteknologi tempe.',
            'deskripsi' => 'Deskripsi lengkap materi bioteknologi tempe.',
            'berkas_pdf' => UploadedFile::fake()->create('modul.pdf', 200, 'application/pdf'),
        ]);

        $eModul = EModul::where('judul', 'Sains dalam Pembuatan Tempe')->firstOrFail();
        $respons->assertRedirect(route('guru.e-modul.edit', $eModul));

        $this->assertSame($guru->id, $eModul->id_pengguna);
        $this->assertSame(StatusPublikasi::Draf, $eModul->status_publikasi);
        Storage::disk('public')->assertExists($eModul->berkas_pdf);
    }

    public function test_guru_dapat_mengajukan_e_modul_untuk_ditinjau(): void
    {
        Storage::fake('public');
        $guru = $this->buatGuru();
        $eModul = EModul::factory()->for($guru, 'pengguna')->create([
            'id_jenjang_pendidikan' => $this->buatJenjangPendidikan()->id,
            'id_mata_pelajaran' => $this->buatMataPelajaran()->id,
            'status_publikasi' => StatusPublikasi::Draf,
            'berkas_pdf' => 'e-modul/pdf/contoh.pdf',
        ]);

        $this->actingAs($guru)
            ->post(route('guru.e-modul.ajukan', $eModul))
            ->assertRedirect(route('guru.e-modul.index'));

        $this->assertSame(StatusPublikasi::Diajukan, $eModul->fresh()->status_publikasi);
        $this->assertDatabaseHas('riwayat_status_e_modul', ['id_e_modul' => $eModul->id]);
    }

    public function test_guru_tidak_dapat_mengubah_e_modul_milik_guru_lain(): void
    {
        $guruA = $this->buatGuru();
        $guruB = $this->buatGuru();
        $eModul = EModul::factory()->for($guruA, 'pengguna')->create([
            'id_jenjang_pendidikan' => $this->buatJenjangPendidikan()->id,
            'id_mata_pelajaran' => $this->buatMataPelajaran()->id,
        ]);

        $this->actingAs($guruB)
            ->get(route('guru.e-modul.edit', $eModul))
            ->assertForbidden();
    }

    public function test_guru_belum_terverifikasi_diarahkan_ke_halaman_menunggu(): void
    {
        $guru = $this->buatGuru(terverifikasi: false);

        $this->actingAs($guru)
            ->get(route('guru.dashboard'))
            ->assertRedirect(route('guru.menunggu-verifikasi'));
    }

    public function test_guru_dapat_menyimpan_draf_e_modul_secara_otomatis(): void
    {
        $guru = $this->buatGuru();
        $eModul = EModul::factory()->for($guru, 'pengguna')->create([
            'id_jenjang_pendidikan' => $this->buatJenjangPendidikan()->id,
            'id_mata_pelajaran' => $this->buatMataPelajaran()->id,
            'status_publikasi' => StatusPublikasi::Draf,
            'judul' => 'Judul Lama',
        ]);

        $respons = $this->actingAs($guru)->patchJson(route('guru.e-modul.simpan-otomatis', $eModul), [
            'judul' => 'Judul Baru Sedang Diketik',
            'ringkasan' => 'Ringkasan yang sedang diketik guru.',
        ]);

        $respons->assertOk()->assertJsonStructure(['tersimpan_pada']);
        $this->assertSame('Judul Baru Sedang Diketik', $eModul->fresh()->judul);
        $this->assertSame('Ringkasan yang sedang diketik guru.', $eModul->fresh()->ringkasan);
    }

    public function test_autosave_tidak_mengubah_status_publikasi(): void
    {
        $guru = $this->buatGuru();
        $eModul = EModul::factory()->for($guru, 'pengguna')->create([
            'id_jenjang_pendidikan' => $this->buatJenjangPendidikan()->id,
            'id_mata_pelajaran' => $this->buatMataPelajaran()->id,
            'status_publikasi' => StatusPublikasi::Dipublikasikan,
            'izin_unduh' => true,
        ]);

        $this->actingAs($guru)->patchJson(route('guru.e-modul.simpan-otomatis', $eModul), [
            'judul' => 'Revisi Kecil',
            'status_publikasi' => 'draf',
            'izin_unduh' => false,
        ])->assertOk();

        $eModul->refresh();
        $this->assertSame(StatusPublikasi::Dipublikasikan, $eModul->status_publikasi);
        $this->assertTrue((bool) $eModul->izin_unduh);
        $this->assertSame('Revisi Kecil', $eModul->judul);
    }

    public function test_guru_tidak_dapat_menyimpan_otomatis_e_modul_milik_guru_lain(): void
    {
        $guruA = $this->buatGuru();
        $guruB = $this->buatGuru();
        $eModul = EModul::factory()->for($guruA, 'pengguna')->create([
            'id_jenjang_pendidikan' => $this->buatJenjangPendidikan()->id,
            'id_mata_pelajaran' => $this->buatMataPelajaran()->id,
        ]);

        $this->actingAs($guruB)
            ->patchJson(route('guru.e-modul.simpan-otomatis', $eModul), ['judul' => 'Coba Ubah'])
            ->assertForbidden();
    }
}
