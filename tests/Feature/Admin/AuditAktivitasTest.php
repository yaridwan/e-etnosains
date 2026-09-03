<?php

namespace Tests\Feature\Admin;

use App\Models\AuditAktivitas;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\MembuatDataDasar;
use Tests\TestCase;

class AuditAktivitasTest extends TestCase
{
    use MembuatDataDasar, RefreshDatabase;

    public function test_filter_modul_menampilkan_hanya_aktivitas_yang_cocok(): void
    {
        $admin = $this->buatAdmin();
        AuditAktivitas::create([
            'id_pengguna' => $admin->id,
            'aktivitas' => 'menyetujui verifikasi guru',
            'modul' => 'verifikasi_guru',
        ]);
        AuditAktivitas::create([
            'id_pengguna' => $admin->id,
            'aktivitas' => 'menyetujui e-modul',
            'modul' => 'e_modul',
        ]);

        $respons = $this->actingAs($admin)->get(route('admin.audit-aktivitas.index', ['modul' => 'e_modul']));

        $respons->assertOk()->assertSee('menyetujui e-modul')->assertDontSee('menyetujui verifikasi guru');
    }

    public function test_pencarian_aktivitas(): void
    {
        $admin = $this->buatAdmin();
        AuditAktivitas::create([
            'id_pengguna' => $admin->id,
            'aktivitas' => 'menghapus tag Kearifan Lokal',
            'modul' => 'tag',
        ]);
        AuditAktivitas::create([
            'id_pengguna' => $admin->id,
            'aktivitas' => 'menyetujui e-modul',
            'modul' => 'e_modul',
        ]);

        $respons = $this->actingAs($admin)->get(route('admin.audit-aktivitas.index', ['q' => 'Kearifan Lokal']));

        $respons->assertOk()->assertSee('menghapus tag Kearifan Lokal')->assertDontSee('menyetujui e-modul');
    }
}
