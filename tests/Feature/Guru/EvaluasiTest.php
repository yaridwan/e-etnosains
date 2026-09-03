<?php

namespace Tests\Feature\Guru;

use App\Enums\StatusPublikasi;
use App\Models\Evaluasi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Concerns\MembuatDataDasar;
use Tests\TestCase;

class EvaluasiTest extends TestCase
{
    use MembuatDataDasar, RefreshDatabase;

    public function test_guru_dapat_membuat_evaluasi_dengan_berkas_pdf(): void
    {
        Storage::fake('public');
        $guru = $this->buatGuru();
        $jenjang = $this->buatJenjangPendidikan();
        $mapel = $this->buatMataPelajaran();

        $respons = $this->actingAs($guru)->post(route('guru.evaluasi.store'), [
            'judul' => 'Ulangan Harian Perubahan Wujud Zat',
            'id_jenjang_pendidikan' => $jenjang->id,
            'id_mata_pelajaran' => $mapel->id,
            'jenis_evaluasi' => 'harian',
            'kkm' => 75,
            'durasi_menit' => 60,
            'berkas_pdf' => UploadedFile::fake()->create('soal.pdf', 200, 'application/pdf'),
        ]);

        $evaluasi = Evaluasi::where('judul', 'Ulangan Harian Perubahan Wujud Zat')->firstOrFail();
        $respons->assertRedirect(route('guru.evaluasi.index'));

        $this->assertSame($guru->id, $evaluasi->id_pengguna);
        $this->assertSame(StatusPublikasi::Dipublikasikan, $evaluasi->status_publikasi);
        Storage::disk('public')->assertExists($evaluasi->berkas_pdf);
    }

    public function test_guru_dapat_mengubah_evaluasi_miliknya(): void
    {
        Storage::fake('public');
        $guru = $this->buatGuru();
        $evaluasi = Evaluasi::factory()->for($guru, 'pengguna')->create([
            'id_jenjang_pendidikan' => $this->buatJenjangPendidikan()->id,
            'id_mata_pelajaran' => $this->buatMataPelajaran()->id,
            'judul' => 'Judul Lama',
        ]);

        $this->actingAs($guru)->put(route('guru.evaluasi.update', $evaluasi), [
            'judul' => 'Judul Baru',
            'id_jenjang_pendidikan' => $evaluasi->id_jenjang_pendidikan,
            'id_mata_pelajaran' => $evaluasi->id_mata_pelajaran,
            'jenis_evaluasi' => 'sumatif',
        ])->assertRedirect();

        $this->assertSame('Judul Baru', $evaluasi->fresh()->judul);
        $this->assertSame('sumatif', $evaluasi->fresh()->jenis_evaluasi);
    }

    public function test_guru_tidak_dapat_mengubah_evaluasi_milik_guru_lain(): void
    {
        $guruA = $this->buatGuru();
        $guruB = $this->buatGuru();
        $evaluasi = Evaluasi::factory()->for($guruA, 'pengguna')->create([
            'id_jenjang_pendidikan' => $this->buatJenjangPendidikan()->id,
            'id_mata_pelajaran' => $this->buatMataPelajaran()->id,
        ]);

        $this->actingAs($guruB)
            ->get(route('guru.evaluasi.edit', $evaluasi))
            ->assertForbidden();
    }

    public function test_guru_dapat_menghapus_evaluasi_miliknya(): void
    {
        $guru = $this->buatGuru();
        $evaluasi = Evaluasi::factory()->for($guru, 'pengguna')->create([
            'id_jenjang_pendidikan' => $this->buatJenjangPendidikan()->id,
            'id_mata_pelajaran' => $this->buatMataPelajaran()->id,
        ]);

        $this->actingAs($guru)
            ->delete(route('guru.evaluasi.destroy', $evaluasi))
            ->assertRedirect(route('guru.evaluasi.index'));

        $this->assertSoftDeleted('evaluasi', ['id' => $evaluasi->id], deletedAtColumn: 'dihapus_pada');
    }
}
