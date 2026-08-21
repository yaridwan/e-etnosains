<?php

namespace Tests\Feature\Admin;

use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\MembuatDataDasar;
use Tests\TestCase;

class MasterDataTest extends TestCase
{
    use MembuatDataDasar, RefreshDatabase;

    public function test_administrator_dapat_menambah_jenjang_pendidikan(): void
    {
        $admin = $this->buatAdmin();

        $this->actingAs($admin)
            ->post(route('admin.jenjang-pendidikan.store'), [
                'nama_jenjang' => 'Pendidikan Anak Usia Dini',
                'urutan' => 0,
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('jenjang_pendidikan', ['nama_jenjang' => 'Pendidikan Anak Usia Dini']);
    }

    public function test_administrator_dapat_menambah_mata_pelajaran(): void
    {
        $admin = $this->buatAdmin();

        $this->actingAs($admin)
            ->post(route('admin.mata-pelajaran.store'), ['nama_mata_pelajaran' => 'Seni Budaya'])
            ->assertRedirect();

        $this->assertDatabaseHas('mata_pelajaran', ['nama_mata_pelajaran' => 'Seni Budaya']);
    }

    public function test_administrator_dapat_menghapus_tag(): void
    {
        $admin = $this->buatAdmin();
        $this->actingAs($admin)->post(route('admin.tag.store'), ['nama_tag' => 'Uji Coba']);

        $tag = Tag::where('nama_tag', 'Uji Coba')->firstOrFail();

        $this->actingAs($admin)
            ->delete(route('admin.tag.destroy', $tag))
            ->assertRedirect();

        $this->assertDatabaseMissing('tag', ['id' => $tag->id]);
    }

    public function test_siswa_tidak_dapat_mengakses_master_data(): void
    {
        $siswa = $this->buatSiswa();

        $this->actingAs($siswa)
            ->get(route('admin.mata-pelajaran.index'))
            ->assertForbidden();
    }
}
