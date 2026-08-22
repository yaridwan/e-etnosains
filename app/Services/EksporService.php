<?php

namespace App\Services;

use Illuminate\Support\Facades\Response;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Layanan umum untuk mengekspor tabel data (pengguna, E-Modul, nilai, dsb.)
 * ke berkas XLSX atau CSV. Dipakai oleh berbagai laporan di dashboard
 * Administrator maupun Guru agar format dan gaya berkas unduhan konsisten.
 */
class EksporService
{
    /**
     * @param  string  $judul  Judul laporan, ditulis di baris pertama berkas.
     * @param  array<int, string>  $kolom  Nama-nama kolom (header tabel).
     * @param  iterable<int, array<int, mixed>>  $baris  Data, satu array per baris, urutan mengikuti $kolom.
     * @param  string  $namaBerkas  Nama berkas tanpa ekstensi.
     * @param  string  $format  "xlsx" atau "csv".
     */
    public function unduh(string $judul, array $kolom, iterable $baris, string $namaBerkas, string $format = 'xlsx'): StreamedResponse
    {
        $spreadsheet = new Spreadsheet;
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Laporan');

        // Judul laporan pada baris pertama, digabung selebar kolom data.
        $kolomTerakhir = $this->hurufKolom(count($kolom));
        $sheet->setCellValue('A1', $judul);
        $sheet->mergeCells("A1:{$kolomTerakhir}1");
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(13);

        $sheet->setCellValue('A2', 'Diunduh pada '.now()->translatedFormat('d F Y, H:i').' WIB');
        $sheet->mergeCells("A2:{$kolomTerakhir}2");
        $sheet->getStyle('A2')->getFont()->setItalic(true)->setSize(9);

        // Header tabel pada baris ke-4.
        $barisHeader = 4;
        foreach (array_values($kolom) as $indeks => $judulKolom) {
            $sheet->setCellValue($this->hurufKolom($indeks + 1).$barisHeader, $judulKolom);
        }
        $rentangHeader = "A{$barisHeader}:{$kolomTerakhir}{$barisHeader}";
        $sheet->getStyle($rentangHeader)->getFont()->setBold(true)->getColor()->setRGB('FFFFFF');
        $sheet->getStyle($rentangHeader)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('0F766E');
        $sheet->getStyle($rentangHeader)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $barisKe = $barisHeader + 1;
        foreach ($baris as $satuBaris) {
            foreach (array_values($satuBaris) as $indeks => $nilai) {
                $sheet->setCellValue($this->hurufKolom($indeks + 1).$barisKe, $nilai);
            }
            $barisKe++;
        }

        foreach (range(1, count($kolom)) as $indeks) {
            $sheet->getColumnDimension($this->hurufKolom($indeks))->setAutoSize(true);
        }

        if ($format === 'csv') {
            $penulis = new Csv($spreadsheet);
            $penulis->setUseBOM(true);
            $namaLengkap = "{$namaBerkas}.csv";
            $tipeKonten = 'text/csv';
        } else {
            $penulis = new Xlsx($spreadsheet);
            $namaLengkap = "{$namaBerkas}.xlsx";
            $tipeKonten = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
        }

        return Response::streamDownload(function () use ($penulis) {
            $penulis->save('php://output');
        }, $namaLengkap, ['Content-Type' => $tipeKonten]);
    }

    private function hurufKolom(int $nomor): string
    {
        $huruf = '';
        while ($nomor > 0) {
            $sisa = ($nomor - 1) % 26;
            $huruf = chr(65 + $sisa).$huruf;
            $nomor = intdiv($nomor - 1, 26);
        }

        return $huruf;
    }
}
