<?php

namespace Database\Seeders;

use App\Enums\StatusPublikasi;
use App\Models\BabEModul;
use App\Models\CatatanPeninjauanEModul;
use App\Models\DaerahEtnosains;
use App\Models\EModul;
use App\Models\JenjangPendidikan;
use App\Models\MataPelajaran;
use App\Models\Peran;
use App\Models\RiwayatStatusEModul;
use App\Models\TopikEtnosains;
use App\Support\PembuatPdfDemo;
use Illuminate\Database\Seeder;

class EModulSeeder extends Seeder
{
    public function run(): void
    {
        $guru = Peran::where('nama_peran', 'guru')->firstOrFail()->pengguna;
        $admin = Peran::where('nama_peran', 'administrator')->firstOrFail()->pengguna->first();
        $jenjangSma = JenjangPendidikan::where('alamat_tautan', 'sma-ma')->first();
        $jenjangSmp = JenjangPendidikan::where('alamat_tautan', 'smp-mts')->first();

        $contoh = [
            [
                'judul' => 'Eksplorasi Sains dalam Proses Pembuatan Gula Aren',
                'mapel' => 'Kimia',
                'topik' => 'Makanan Tradisional',
                'daerah' => 'Banyumas',
                'jenjang' => $jenjangSma,
                'ringkasan' => 'Mengkaji perubahan wujud, kalor, dan proses evaporasi pada pengolahan tradisional nira aren menjadi gula aren.',
                'pengetahuan_lokal' => 'Masyarakat penderes menyadap nira aren pada dini hari dan memasaknya secara bertahap di atas tungku kayu bakar hingga mengental menjadi gula.',
                'konsep_sains' => 'Perubahan wujud zat cair menjadi padat, perpindahan kalor konduksi dan konveksi, serta proses evaporasi dan kristalisasi larutan gula.',
                'aktivitas_saintifik' => 'Siswa mengamati perubahan suhu dan kekentalan nira selama pemasakan, lalu menghubungkannya dengan konsep perpindahan kalor.',
                'nilai_karakter' => 'Ketekunan, kerja keras, dan pelestarian mata pencaharian tradisional penderes aren.',
            ],
            [
                'judul' => 'Keanekaragaman Tanaman Obat dalam Kearifan Lokal',
                'mapel' => 'Biologi',
                'topik' => 'Tanaman Obat',
                'daerah' => 'Bantul',
                'jenjang' => $jenjangSma,
                'ringkasan' => 'Mengenal keanekaragaman hayati tanaman obat tradisional serta klasifikasi dan kandungan senyawa alaminya.',
                'pengetahuan_lokal' => 'Racikan jamu tradisional menggunakan kunyit, temulawak, dan kencur yang diwariskan turun-temurun oleh keluarga peracik jamu.',
                'konsep_sains' => 'Klasifikasi tumbuhan, keanekaragaman hayati, dan identifikasi senyawa metabolit sekunder pada tanaman obat.',
                'aktivitas_saintifik' => 'Siswa mengidentifikasi dan mengklasifikasikan tanaman obat di sekitar sekolah lalu menyusun herbarium sederhana.',
                'nilai_karakter' => 'Pelestarian pengetahuan tradisional dan kepedulian terhadap kesehatan keluarga.',
            ],
            [
                'judul' => 'Ekosistem Sawah sebagai Laboratorium Sains Lokal',
                'mapel' => 'IPA',
                'topik' => 'Ekosistem',
                'daerah' => 'Subang',
                'jenjang' => $jenjangSmp,
                'ringkasan' => 'Mempelajari rantai makanan dan interaksi makhluk hidup pada ekosistem sawah dengan sistem terasering.',
                'pengetahuan_lokal' => 'Sistem sawah terasering dan pola tanam serempak yang mengatur keseimbangan hama secara alami.',
                'konsep_sains' => 'Rantai makanan, jaring-jaring makanan, dan interaksi antar komponen biotik-abiotik ekosistem sawah.',
                'aktivitas_saintifik' => 'Siswa melakukan observasi lapangan untuk mendata organisme di sawah dan menyusun jaring-jaring makanan.',
                'nilai_karakter' => 'Gotong royong dalam sistem tanam serempak dan kepedulian lingkungan.',
            ],
            [
                'judul' => 'Sains dalam Teknologi Pengolahan Makanan Tradisional',
                'mapel' => 'Kimia',
                'topik' => 'Pengolahan Pangan',
                'daerah' => 'Agam',
                'jenjang' => $jenjangSma,
                'ringkasan' => 'Mengkaji prinsip pengawetan pangan tradisional pada pembuatan rendang khas Minangkabau.',
                'pengetahuan_lokal' => 'Proses memasak rendang dalam waktu lama menggunakan santan dan rempah sebagai pengawet alami.',
                'konsep_sains' => 'Reaksi Maillard, dehidrasi, dan sifat antimikroba senyawa rempah sebagai pengawet alami.',
                'aktivitas_saintifik' => 'Siswa mengamati perubahan warna, tekstur, dan kadar air selama proses memasak rendang.',
                'nilai_karakter' => 'Kesabaran, ketelitian, dan pelestarian warisan kuliner Minangkabau.',
            ],
            [
                'judul' => 'Konservasi Air dalam Kearifan Lokal Masyarakat Subak',
                'mapel' => 'Pendidikan Lingkungan Hidup',
                'topik' => 'Sumber Daya Air',
                'daerah' => 'Tabanan',
                'jenjang' => $jenjangSmp,
                'ringkasan' => 'Mempelajari sistem irigasi Subak sebagai model konservasi air berbasis kearifan lokal Bali.',
                'pengetahuan_lokal' => 'Sistem Subak mengatur pembagian air irigasi secara adil antar petani berdasarkan musyawarah adat.',
                'konsep_sains' => 'Siklus hidrologi, debit air, dan prinsip konservasi sumber daya air.',
                'aktivitas_saintifik' => 'Siswa menghitung debit air sederhana dan mendiskusikan efisiensi pembagian air pada sistem irigasi.',
                'nilai_karakter' => 'Musyawarah, keadilan, dan gotong royong dalam pengelolaan sumber daya bersama.',
            ],
        ];

        foreach ($contoh as $i => $data) {
            $penulis = $guru[$i % $guru->count()];
            $mapel = MataPelajaran::where('nama_mata_pelajaran', $data['mapel'])->first() ?? MataPelajaran::first();
            $topik = TopikEtnosains::where('nama_topik', $data['topik'])->first();
            $daerah = DaerahEtnosains::where('kabupaten_kota', $data['daerah'])->first();

            $eModul = EModul::create([
                'id_pengguna' => $penulis->id,
                'id_jenjang_pendidikan' => $data['jenjang']->id,
                'id_mata_pelajaran' => $mapel->id,
                'id_topik_etnosains' => $topik?->id,
                'id_daerah_etnosains' => $daerah?->id,
                'judul' => $data['judul'],
                'ringkasan' => $data['ringkasan'],
                'deskripsi' => $data['ringkasan'].' '.$data['pengetahuan_lokal'],
                'capaian_pembelajaran' => 'Peserta didik mampu menjelaskan konsep sains yang terkandung dalam praktik kearifan lokal setempat.',
                'tujuan_pembelajaran' => 'Menghubungkan fenomena budaya dengan konsep sains serta menumbuhkan apresiasi terhadap kearifan lokal.',
                'kelas' => $data['jenjang']->alamat_tautan === 'sma-ma' ? 'X' : 'VIII',
                'fase' => $data['jenjang']->alamat_tautan === 'sma-ma' ? 'E' : 'D',
                'tahun' => now()->year,
                'kata_kunci' => $data['topik'].', etnosains, kearifan lokal',
                'izin_unduh' => true,
                'pengetahuan_lokal' => $data['pengetahuan_lokal'],
                'konsep_sains' => $data['konsep_sains'],
                'konteks_wilayah' => $data['daerah'],
                'aktivitas_saintifik' => $data['aktivitas_saintifik'],
                'nilai_karakter' => $data['nilai_karakter'],
                'status_publikasi' => StatusPublikasi::Dipublikasikan,
                'unggulan' => $i < 3,
                'jumlah_dilihat' => fake()->numberBetween(150, 3200),
                'jumlah_diunduh' => fake()->numberBetween(30, 900),
                'dipublikasikan_pada' => now()->subDays(fake()->numberBetween(5, 180)),
            ]);

            $bagianPdf = [
                'Pendahuluan' => $data['ringkasan'],
                'Kajian Etnosains: '.$data['topik'] => $data['pengetahuan_lokal'],
                'Konsep Sains Terkait' => $data['konsep_sains'],
                'Aktivitas Pembelajaran' => $data['aktivitas_saintifik'],
                'Nilai dan Karakter' => $data['nilai_karakter'],
                'Evaluasi' => 'Jawablah pertanyaan refleksi mengenai hubungan antara '.$data['topik'].' dengan konsep sains yang telah dipelajari.',
            ];
            [$berkasPdf, $jumlahHalaman] = PembuatPdfDemo::buat($data['judul'], $bagianPdf, 'e-modul/pdf');
            $eModul->update(['berkas_pdf' => $berkasPdf, 'jumlah_halaman' => $jumlahHalaman]);

            foreach (array_keys($bagianPdf) as $urutan => $judulBab) {
                BabEModul::create([
                    'id_e_modul' => $eModul->id,
                    'judul_bab' => $judulBab,
                    'nomor_urut' => $urutan + 1,
                    'halaman_mulai' => $urutan + 1,
                ]);
            }

            RiwayatStatusEModul::create([
                'id_e_modul' => $eModul->id,
                'status_sebelum' => 'diajukan',
                'status_sesudah' => 'dipublikasikan',
                'catatan' => 'Konten lengkap dan sesuai kaidah etnosains.',
                'id_pengguna' => $admin->id,
            ]);

            CatatanPeninjauanEModul::create([
                'id_e_modul' => $eModul->id,
                'id_pengguna' => $admin->id,
                'catatan' => 'Materi baik, hubungan etnosains dan konsep sains sudah jelas.',
                'keputusan' => 'disetujui',
            ]);
        }

        // Contoh workflow: e-modul diajukan (menunggu review) & draf
        [$berkasDiajukan, $halamanDiajukan] = PembuatPdfDemo::buat(
            'Sains di Balik Kerajinan Anyaman Bambu',
            ['Pendahuluan' => 'Kerajinan anyaman bambu merupakan salah satu warisan budaya yang sarat akan prinsip sains sederhana.'],
            'e-modul/pdf'
        );

        EModul::factory()->diajukan()->create([
            'id_pengguna' => $guru->first()->id,
            'judul' => 'Sains di Balik Kerajinan Anyaman Bambu',
            'berkas_pdf' => $berkasDiajukan,
            'jumlah_halaman' => $halamanDiajukan,
        ]);

        EModul::factory()->draf()->create([
            'id_pengguna' => $guru->last()->id,
            'judul' => 'Fermentasi Tradisional Tempe dan Konsep Bioteknologi',
        ]);

        EModul::factory()->count(1)->create();
    }
}
