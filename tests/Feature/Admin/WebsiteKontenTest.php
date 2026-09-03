<?php

namespace Tests\Feature\Admin;

use App\Models\Faq;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\MembuatDataDasar;
use Tests\TestCase;

class WebsiteKontenTest extends TestCase
{
    use MembuatDataDasar, RefreshDatabase;

    public function test_pencarian_faq_hanya_menampilkan_yang_cocok(): void
    {
        $admin = $this->buatAdmin();
        Faq::create(['pertanyaan' => 'Apa itu E-ETNOSAINS?', 'jawaban' => 'Platform pembelajaran etnosains.', 'aktif' => true]);
        Faq::create(['pertanyaan' => 'Bagaimana cara mendaftar?', 'jawaban' => 'Klik tombol daftar.', 'aktif' => true]);

        $respons = $this->actingAs($admin)->get(route('admin.faq.index', ['q' => 'E-ETNOSAINS']));

        $respons->assertOk()->assertSee('Apa itu E-ETNOSAINS?')->assertDontSee('Bagaimana cara mendaftar?');
    }

    public function test_filter_status_faq(): void
    {
        $admin = $this->buatAdmin();
        Faq::create(['pertanyaan' => 'Pertanyaan Aktif', 'jawaban' => 'Jawaban.', 'aktif' => true]);
        Faq::create(['pertanyaan' => 'Pertanyaan Nonaktif', 'jawaban' => 'Jawaban.', 'aktif' => false]);

        $respons = $this->actingAs($admin)->get(route('admin.faq.index', ['status' => 'nonaktif']));

        $respons->assertOk()->assertSee('Pertanyaan Nonaktif')->assertDontSee('Pertanyaan Aktif');
    }
}
