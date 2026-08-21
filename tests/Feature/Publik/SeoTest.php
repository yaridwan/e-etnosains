<?php

namespace Tests\Feature\Publik;

use App\Enums\StatusPublikasi;
use App\Models\EModul;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\MembuatDataDasar;
use Tests\TestCase;

class SeoTest extends TestCase
{
    use MembuatDataDasar, RefreshDatabase;

    public function test_sitemap_memuat_e_modul_yang_dipublikasikan(): void
    {
        $guru = $this->buatGuru();
        $eModul = EModul::factory()->for($guru, 'pengguna')->create([
            'id_jenjang_pendidikan' => $this->buatJenjangPendidikan()->id,
            'id_mata_pelajaran' => $this->buatMataPelajaran()->id,
            'status_publikasi' => StatusPublikasi::Dipublikasikan,
        ]);

        $this->get(route('sitemap'))
            ->assertOk()
            ->assertHeader('Content-Type', 'text/xml; charset=UTF-8')
            ->assertSee($eModul->alamat_tautan);
    }

    public function test_sitemap_tidak_memuat_e_modul_draf(): void
    {
        $guru = $this->buatGuru();
        $draf = EModul::factory()->for($guru, 'pengguna')->create([
            'id_jenjang_pendidikan' => $this->buatJenjangPendidikan()->id,
            'id_mata_pelajaran' => $this->buatMataPelajaran()->id,
            'status_publikasi' => StatusPublikasi::Draf,
        ]);

        $this->get(route('sitemap'))
            ->assertOk()
            ->assertDontSee($draf->alamat_tautan);
    }

    public function test_robots_txt_melarang_area_privat(): void
    {
        $this->get(route('robots'))
            ->assertOk()
            ->assertSee('Disallow: /admin')
            ->assertSee('Disallow: /guru')
            ->assertSee('Disallow: /siswa')
            ->assertSee(route('sitemap'));
    }

    public function test_halaman_publik_tidak_diberi_noindex(): void
    {
        $this->get(route('beranda'))
            ->assertOk()
            ->assertDontSee('noindex');
    }

    public function test_halaman_autentikasi_diberi_noindex(): void
    {
        $this->get(route('masuk'))
            ->assertOk()
            ->assertSee('noindex', false);
    }

    public function test_profil_guru_publik_berada_di_luar_prefiks_guru(): void
    {
        $guru = $this->buatGuru();

        // Profil publik tidak boleh berada di /guru/... agar tidak ikut terblokir
        // oleh aturan Disallow: /guru pada robots.txt.
        $this->assertStringContainsString('/profil-guru/', route('guru.profil', $guru));

        $this->get(route('guru.profil', $guru))->assertOk();
    }
}
