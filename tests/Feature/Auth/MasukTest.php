<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\MembuatDataDasar;
use Tests\TestCase;

class MasukTest extends TestCase
{
    use MembuatDataDasar, RefreshDatabase;

    public function test_halaman_masuk_dapat_diakses(): void
    {
        $this->get(route('masuk'))->assertOk();
    }

    public function test_pengguna_dapat_masuk_dengan_kredensial_benar(): void
    {
        $admin = $this->buatAdmin(['email' => 'admin@contoh.test', 'kata_sandi' => 'password123']);

        $respons = $this->post(route('masuk.proses'), [
            'email' => 'admin@contoh.test',
            'kata_sandi' => 'password123',
        ]);

        $respons->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($admin);
    }

    public function test_pengguna_gagal_masuk_dengan_kata_sandi_salah(): void
    {
        $this->buatAdmin(['email' => 'admin@contoh.test', 'kata_sandi' => 'password123']);

        $respons = $this->post(route('masuk.proses'), [
            'email' => 'admin@contoh.test',
            'kata_sandi' => 'salah-sandi',
        ]);

        $respons->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_guru_diarahkan_ke_dashboard_guru(): void
    {
        $guru = $this->buatGuru(['email' => 'guru@contoh.test', 'kata_sandi' => 'password123']);

        $this->post(route('masuk.proses'), [
            'email' => 'guru@contoh.test',
            'kata_sandi' => 'password123',
        ])->assertRedirect(route('guru.dashboard'));

        $this->assertAuthenticatedAs($guru);
    }

    public function test_siswa_diarahkan_ke_dashboard_siswa(): void
    {
        $siswa = $this->buatSiswa(['email' => 'siswa@contoh.test', 'kata_sandi' => 'password123']);

        $this->post(route('masuk.proses'), [
            'email' => 'siswa@contoh.test',
            'kata_sandi' => 'password123',
        ])->assertRedirect(route('siswa.dashboard'));

        $this->assertAuthenticatedAs($siswa);
    }

    public function test_pengguna_dapat_keluar(): void
    {
        $admin = $this->buatAdmin(['kata_sandi' => 'password123']);

        $this->actingAs($admin)->post(route('keluar'))->assertRedirect(route('beranda'));

        $this->assertGuest();
    }
}
