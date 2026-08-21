<?php

namespace Database\Seeders;

use App\Enums\JenisPertanyaan;
use App\Enums\StatusPublikasi;
use App\Models\ButirObservasi;
use App\Models\EModul;
use App\Models\Observasi;
use App\Models\OpsiButirObservasi;
use Illuminate\Database\Seeder;

class ObservasiSeeder extends Seeder
{
    public function run(): void
    {
        $gulaAren = EModul::where('judul', 'like', '%Gula Aren%')->first();
        $tanamanObat = EModul::where('judul', 'like', '%Tanaman Obat%')->first();

        $observasi1 = Observasi::create([
            'id_pengguna' => $gulaAren->id_pengguna,
            'id_e_modul' => $gulaAren->id,
            'judul' => 'Observasi Proses Pembuatan Gula Aren dan Konsep Perubahan Zat',
            'deskripsi' => 'Siswa mengamati langsung proses penyadapan dan pemasakan nira aren di lingkungan sekitar.',
            'tujuan' => 'Mengidentifikasi tahapan perubahan wujud zat selama proses pembuatan gula aren.',
            'petunjuk' => 'Kunjungi perajin gula aren terdekat, amati proses pemasakan, dan catat perubahan yang terjadi.',
            'lokasi_observasi' => 'Rumah produksi gula aren di lingkungan sekitar siswa',
            'durasi' => '2 jam',
            'alat_dan_bahan' => 'Termometer, alat tulis, kamera/ponsel untuk dokumentasi',
            'prosedur' => '1) Amati proses penyadapan nira. 2) Amati proses pemasakan. 3) Catat perubahan suhu dan wujud. 4) Dokumentasikan hasil akhir.',
            'aspek_keselamatan' => 'Jaga jarak aman dari tungku dan cairan panas selama observasi.',
            'batas_pengumpulan' => now()->addDays(14),
            'status_publikasi' => StatusPublikasi::Dipublikasikan,
        ]);

        $this->buatButirGulaAren($observasi1);

        $observasi2 = Observasi::create([
            'id_pengguna' => $tanamanObat->id_pengguna,
            'id_e_modul' => $tanamanObat->id,
            'judul' => 'Observasi Pemanfaatan Tanaman Obat Tradisional di Lingkungan Masyarakat',
            'deskripsi' => 'Siswa mendata jenis dan pemanfaatan tanaman obat yang digunakan masyarakat sekitar.',
            'tujuan' => 'Mengidentifikasi keanekaragaman dan pemanfaatan tanaman obat tradisional.',
            'petunjuk' => 'Wawancarai anggota keluarga atau tetangga mengenai tanaman obat yang biasa digunakan.',
            'lokasi_observasi' => 'Lingkungan tempat tinggal siswa',
            'durasi' => '1 minggu',
            'alat_dan_bahan' => 'Buku catatan, kamera/ponsel, formulir wawancara',
            'prosedur' => '1) Wawancara narasumber. 2) Identifikasi tanaman obat. 3) Dokumentasi foto tanaman. 4) Susun laporan sederhana.',
            'aspek_keselamatan' => 'Berhati-hati saat mengambil sampel tanaman, hindari tanaman beracun.',
            'batas_pengumpulan' => now()->addDays(14),
            'status_publikasi' => StatusPublikasi::Dipublikasikan,
        ]);

        $this->buatButirTanamanObat($observasi2);

        Observasi::factory()->count(2)->create()->each(function (Observasi $observasi) {
            ButirObservasi::create([
                'id_observasi' => $observasi->id,
                'pertanyaan' => 'Jelaskan hasil pengamatan Anda secara singkat.',
                'tipe_pertanyaan' => JenisPertanyaan::TeksPanjang,
                'wajib' => true,
                'urutan' => 1,
            ]);
        });
    }

    private function buatButirGulaAren(Observasi $observasi): void
    {
        $butir1 = ButirObservasi::create([
            'id_observasi' => $observasi->id,
            'pertanyaan' => 'Berapa suhu nira sebelum dan sesudah dimasak?',
            'tipe_pertanyaan' => JenisPertanyaan::Angka,
            'wajib' => true,
            'urutan' => 1,
        ]);

        $butir2 = ButirObservasi::create([
            'id_observasi' => $observasi->id,
            'pertanyaan' => 'Perubahan wujud apa yang paling terlihat selama proses pemasakan?',
            'tipe_pertanyaan' => JenisPertanyaan::PilihanTunggal,
            'wajib' => true,
            'urutan' => 2,
        ]);

        foreach (['Cair menjadi kental (kristalisasi)', 'Menguapnya air (evaporasi)', 'Perubahan warna saja'] as $urutan => $opsi) {
            OpsiButirObservasi::create([
                'id_butir_observasi' => $butir2->id,
                'teks_opsi' => $opsi,
                'urutan' => $urutan + 1,
            ]);
        }

        ButirObservasi::create([
            'id_observasi' => $observasi->id,
            'pertanyaan' => 'Unggah foto dokumentasi proses pemasakan.',
            'tipe_pertanyaan' => JenisPertanyaan::UnggahFoto,
            'wajib' => false,
            'urutan' => 3,
        ]);

        ButirObservasi::create([
            'id_observasi' => $observasi->id,
            'pertanyaan' => 'Jelaskan kesimpulan Anda mengenai konsep sains yang ditemukan.',
            'tipe_pertanyaan' => JenisPertanyaan::TeksPanjang,
            'wajib' => true,
            'urutan' => 4,
        ]);
    }

    private function buatButirTanamanObat(Observasi $observasi): void
    {
        ButirObservasi::create([
            'id_observasi' => $observasi->id,
            'pertanyaan' => 'Sebutkan nama tanaman obat yang Anda temukan.',
            'tipe_pertanyaan' => JenisPertanyaan::TeksPendek,
            'wajib' => true,
            'urutan' => 1,
        ]);

        ButirObservasi::create([
            'id_observasi' => $observasi->id,
            'pertanyaan' => 'Berapa jumlah jenis tanaman obat yang berhasil didata?',
            'tipe_pertanyaan' => JenisPertanyaan::Angka,
            'wajib' => true,
            'urutan' => 2,
        ]);

        ButirObservasi::create([
            'id_observasi' => $observasi->id,
            'pertanyaan' => 'Unggah foto tanaman obat yang ditemukan.',
            'tipe_pertanyaan' => JenisPertanyaan::UnggahFoto,
            'wajib' => false,
            'urutan' => 3,
        ]);

        ButirObservasi::create([
            'id_observasi' => $observasi->id,
            'pertanyaan' => 'Apakah masyarakat masih rutin menggunakan tanaman obat tersebut?',
            'tipe_pertanyaan' => JenisPertanyaan::YaTidak,
            'wajib' => true,
            'urutan' => 4,
        ]);
    }
}
