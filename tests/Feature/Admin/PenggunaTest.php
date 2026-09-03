<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\Concerns\MembuatDataDasar;
use Tests\TestCase;

class PenggunaTest extends TestCase
{
    use MembuatDataDasar, RefreshDatabase;

    public function test_administrator_dapat_mengedit_profil_pengguna(): void
    {
        $admin = $this->buatAdmin();
        $siswa = $this->buatSiswa();

        $this->actingAs($admin)
            ->put(route('admin.pengguna.update', $siswa), [
                'nama_lengkap' => 'Nama Baru',
                'email' => 'baru@e-etnosains.test',
                'nomor_telepon' => '081234567890',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('pengguna', [
            'id' => $siswa->id,
            'nama_lengkap' => 'Nama Baru',
            'email' => 'baru@e-etnosains.test',
        ]);
    }

    public function test_administrator_dapat_mengubah_kata_sandi_pengguna(): void
    {
        $admin = $this->buatAdmin();
        $siswa = $this->buatSiswa();

        $this->actingAs($admin)
            ->put(route('admin.pengguna.ubah-kata-sandi', $siswa), [
                'kata_sandi' => 'kata-sandi-baru',
                'kata_sandi_confirmation' => 'kata-sandi-baru',
            ])
            ->assertRedirect();

        $this->assertTrue(Hash::check('kata-sandi-baru', $siswa->fresh()->kata_sandi));
    }

    public function test_administrator_dapat_memblokir_pengguna(): void
    {
        $admin = $this->buatAdmin();
        $guru = $this->buatGuru();

        $this->actingAs($admin)
            ->patch(route('admin.pengguna.ubah-status', $guru), ['status_akun' => 'nonaktif'])
            ->assertRedirect();

        $this->assertDatabaseHas('pengguna', ['id' => $guru->id, 'status_akun' => 'nonaktif']);
    }

    public function test_administrator_dapat_menghapus_pengguna(): void
    {
        $admin = $this->buatAdmin();
        $siswa = $this->buatSiswa();

        $this->actingAs($admin)
            ->delete(route('admin.pengguna.destroy', $siswa))
            ->assertRedirect(route('admin.pengguna.index'));

        $this->assertSoftDeleted('pengguna', ['id' => $siswa->id], deletedAtColumn: 'dihapus_pada');
    }

    public function test_administrator_tidak_dapat_menghapus_akun_sendiri(): void
    {
        $admin = $this->buatAdmin();

        $this->actingAs($admin)
            ->delete(route('admin.pengguna.destroy', $admin))
            ->assertRedirect();

        $this->assertDatabaseHas('pengguna', ['id' => $admin->id, 'dihapus_pada' => null]);
    }

    public function test_administrator_tidak_dapat_memblokir_akun_sendiri(): void
    {
        $admin = $this->buatAdmin();

        $this->actingAs($admin)
            ->patch(route('admin.pengguna.ubah-status', $admin), ['status_akun' => 'nonaktif'])
            ->assertRedirect();

        $this->assertDatabaseHas('pengguna', ['id' => $admin->id, 'status_akun' => 'aktif']);
    }
}
