<?php

namespace Tests\Feature\Publik;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BerandaTest extends TestCase
{
    use RefreshDatabase;

    public function test_halaman_beranda_dapat_diakses_tanpa_login(): void
    {
        $this->get('/')->assertOk();
    }

    public function test_halaman_e_modul_dapat_diakses_tanpa_login(): void
    {
        $this->get(route('e-modul.index'))->assertOk();
    }

    public function test_halaman_faq_beranda_tidak_error(): void
    {
        $this->get('/')->assertOk()->assertSee('E-ETNOSAINS');
    }
}
