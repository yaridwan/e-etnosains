<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\MembuatDataDasar;
use Tests\TestCase;

class VerifikasiEmailRedirectTest extends TestCase
{
    use MembuatDataDasar, RefreshDatabase;

    public function test_pengguna_belum_terverifikasi_diarahkan_ke_halaman_verifikasi_bukan_error(): void
    {
        $guru = $this->buatGuru(['email_terverifikasi_pada' => null]);

        $this->actingAs($guru)
            ->get(route('guru.dashboard'))
            ->assertRedirect(route('verifikasi-email.notice'));
    }
}
