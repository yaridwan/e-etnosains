<?php

namespace App\Support;

use Illuminate\Support\Facades\Session;

/**
 * Captcha penjumlahan sederhana untuk menahan bot pengisi formulir.
 *
 * Jawaban benar disimpan di sesi (sisi server), bukan pada input tersembunyi,
 * sehingga tidak dapat dibaca atau dipalsukan dari sisi peramban.
 */
class CaptchaPenjumlahan
{
    private const KUNCI_SESI = 'captcha_penjumlahan';

    /**
     * Membuat soal baru dan menyimpan jawabannya ke sesi.
     *
     * Jumlah hasil dijamin berbeda dari soal sebelumnya. Tanpa jaminan ini,
     * soal acak berikutnya bisa kebetulan bernilai sama (mis. 3+8 lalu 5+6)
     * sehingga jawaban dari percobaan yang gagal masih dapat dipakai ulang.
     *
     * @return array{angka_pertama: int, angka_kedua: int, pertanyaan: string}
     */
    public static function buat(): array
    {
        $sebelumnya = Session::get(self::KUNCI_SESI);

        do {
            $pertama = random_int(1, 9);
            $kedua = random_int(1, 9);
            $jumlah = $pertama + $kedua;
        } while ($sebelumnya !== null && $jumlah === (int) $sebelumnya);

        Session::put(self::KUNCI_SESI, $jumlah);

        return [
            'angka_pertama' => $pertama,
            'angka_kedua' => $kedua,
            'pertanyaan' => "Berapa hasil dari {$pertama} + {$kedua}?",
        ];
    }

    /**
     * Mengambil soal yang sedang berlaku, atau membuat yang baru bila belum ada.
     *
     * @return array{angka_pertama: int, angka_kedua: int, pertanyaan: string}
     */
    public static function soal(): array
    {
        return Session::get(self::KUNCI_SESI.'_soal') ?? tap(self::buat(), function (array $soal) {
            Session::put(self::KUNCI_SESI.'_soal', $soal);
        });
    }

    /**
     * Membuat soal baru dan sekaligus menyimpannya agar konsisten saat
     * halaman dirender ulang (misalnya setelah galat validasi).
     *
     * @return array{angka_pertama: int, angka_kedua: int, pertanyaan: string}
     */
    public static function segarkan(): array
    {
        $soal = self::buat();
        Session::put(self::KUNCI_SESI.'_soal', $soal);

        return $soal;
    }

    public static function benar(mixed $jawaban): bool
    {
        $kunci = Session::get(self::KUNCI_SESI);

        if ($kunci === null || ! is_numeric($jawaban)) {
            return false;
        }

        return (int) $jawaban === (int) $kunci;
    }

    public static function bersihkan(): void
    {
        Session::forget([self::KUNCI_SESI, self::KUNCI_SESI.'_soal']);
    }
}
