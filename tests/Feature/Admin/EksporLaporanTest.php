<?php

namespace Tests\Feature\Admin;

use App\Enums\StatusPublikasi;
use App\Models\EModul;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\MembuatDataDasar;
use Tests\TestCase;

class EksporLaporanTest extends TestCase
{
    use MembuatDataDasar, RefreshDatabase;

    public function test_administrator_dapat_mengunduh_laporan_pengguna_xlsx(): void
    {
        $admin = $this->buatAdmin();
        $this->buatGuru();

        $respons = $this->actingAs($admin)->get(route('admin.pengguna.ekspor'));

        $respons->assertOk();
        $respons->assertHeader('content-type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }

    public function test_administrator_dapat_mengunduh_laporan_pengguna_csv(): void
    {
        $admin = $this->buatAdmin();

        $respons = $this->actingAs($admin)->get(route('admin.pengguna.ekspor', ['format' => 'csv']));

        $respons->assertOk();
        $respons->assertHeader('content-type', 'text/csv; charset=UTF-8');
    }

    public function test_guru_tidak_dapat_mengakses_ekspor_laporan_pengguna(): void
    {
        $guru = $this->buatGuru();

        $this->actingAs($guru)->get(route('admin.pengguna.ekspor'))->assertForbidden();
    }

    public function test_administrator_dapat_mengunduh_laporan_e_modul(): void
    {
        $admin = $this->buatAdmin();
        $guru = $this->buatGuru();
        EModul::factory()->for($guru, 'pengguna')->create([
            'id_jenjang_pendidikan' => $this->buatJenjangPendidikan()->id,
            'id_mata_pelajaran' => $this->buatMataPelajaran()->id,
            'status_publikasi' => StatusPublikasi::Diajukan,
        ]);

        $this->actingAs($admin)->get(route('admin.tinjau-e-modul.ekspor'))->assertOk();
    }
}
