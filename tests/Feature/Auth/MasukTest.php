<?php

namespace Tests\Feature\Auth;

use App\Support\CaptchaPenjumlahan;
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

    public function test_halaman_masuk_menampilkan_soal_captcha_penjumlahan(): void
    {
        $this->get(route('masuk'))
            ->assertOk()
            ->assertSee('Verifikasi Keamanan')
            ->assertSee('name="jawaban_captcha"', false);
    }

    public function test_pengguna_dapat_masuk_dengan_kredensial_benar(): void
    {
        $admin = $this->buatAdmin(['email' => 'admin@contoh.test', 'kata_sandi' => 'password123']);

        $respons = $this->post(route('masuk.proses'), $this->dataMasuk([
            'email' => 'admin@contoh.test',
            'kata_sandi' => 'password123',
        ]));

        $respons->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($admin);
    }

    public function test_pengguna_gagal_masuk_dengan_kata_sandi_salah(): void
    {
        $this->buatAdmin(['email' => 'admin@contoh.test', 'kata_sandi' => 'password123']);

        $respons = $this->post(route('masuk.proses'), $this->dataMasuk([
            'email' => 'admin@contoh.test',
            'kata_sandi' => 'salah-sandi',
        ]));

        $respons->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_masuk_ditolak_bila_jawaban_captcha_salah(): void
    {
        $this->buatAdmin(['email' => 'admin@contoh.test', 'kata_sandi' => 'password123']);

        $soal = CaptchaPenjumlahan::segarkan();
        $jawabanSalah = $soal['angka_pertama'] + $soal['angka_kedua'] + 1;

        $this->post(route('masuk.proses'), [
            'email' => 'admin@contoh.test',
            'kata_sandi' => 'password123',
            'jawaban_captcha' => $jawabanSalah,
        ])->assertSessionHasErrors('jawaban_captcha');

        $this->assertGuest();
    }

    public function test_masuk_ditolak_bila_captcha_tidak_diisi(): void
    {
        $this->buatAdmin(['email' => 'admin@contoh.test', 'kata_sandi' => 'password123']);

        $this->post(route('masuk.proses'), [
            'email' => 'admin@contoh.test',
            'kata_sandi' => 'password123',
        ])->assertSessionHasErrors('jawaban_captcha');

        $this->assertGuest();
    }

    public function test_soal_captcha_baru_selalu_berbeda_dari_soal_sebelumnya(): void
    {
        // Tanpa jaminan ini, soal pengganti bisa bernilai sama sehingga jawaban
        // dari percobaan gagal masih dapat dipakai ulang.
        $sebelumnya = CaptchaPenjumlahan::segarkan();
        $jumlahSebelumnya = $sebelumnya['angka_pertama'] + $sebelumnya['angka_kedua'];

        for ($i = 0; $i < 30; $i++) {
            $berikutnya = CaptchaPenjumlahan::segarkan();
            $jumlahBerikutnya = $berikutnya['angka_pertama'] + $berikutnya['angka_kedua'];

            $this->assertNotSame($jumlahSebelumnya, $jumlahBerikutnya);

            $jumlahSebelumnya = $jumlahBerikutnya;
        }
    }

    public function test_jawaban_captcha_yang_sama_tidak_dapat_dipakai_ulang(): void
    {
        $this->buatAdmin(['email' => 'admin@contoh.test', 'kata_sandi' => 'password123']);

        $soal = CaptchaPenjumlahan::segarkan();
        $jawaban = $soal['angka_pertama'] + $soal['angka_kedua'];

        // Percobaan pertama gagal karena kata sandi salah; soal harus diganti.
        $this->post(route('masuk.proses'), [
            'email' => 'admin@contoh.test',
            'kata_sandi' => 'salah-sandi',
            'jawaban_captcha' => $jawaban,
        ])->assertSessionHasErrors('email');

        // Soal sudah berganti, jawaban lama tidak lagi berlaku.
        $this->post(route('masuk.proses'), [
            'email' => 'admin@contoh.test',
            'kata_sandi' => 'password123',
            'jawaban_captcha' => $jawaban,
        ])->assertSessionHasErrors('jawaban_captcha');

        $this->assertGuest();
    }

    public function test_guru_diarahkan_ke_dashboard_guru(): void
    {
        $guru = $this->buatGuru(['email' => 'guru@contoh.test', 'kata_sandi' => 'password123']);

        $this->post(route('masuk.proses'), $this->dataMasuk([
            'email' => 'guru@contoh.test',
            'kata_sandi' => 'password123',
        ]))->assertRedirect(route('guru.dashboard'));

        $this->assertAuthenticatedAs($guru);
    }

    public function test_siswa_diarahkan_ke_dashboard_siswa(): void
    {
        $siswa = $this->buatSiswa(['email' => 'siswa@contoh.test', 'kata_sandi' => 'password123']);

        $this->post(route('masuk.proses'), $this->dataMasuk([
            'email' => 'siswa@contoh.test',
            'kata_sandi' => 'password123',
        ]))->assertRedirect(route('siswa.dashboard'));

        $this->assertAuthenticatedAs($siswa);
    }

    public function test_pengguna_dapat_keluar(): void
    {
        $admin = $this->buatAdmin(['kata_sandi' => 'password123']);

        $this->actingAs($admin)->post(route('keluar'))->assertRedirect(route('beranda'));

        $this->assertGuest();
    }
}
