@php($sedangUbah = $lkpd->exists)

<x-layout-dashboard :judul-seo="$sedangUbah ? 'Ubah LKPD' : 'Buat LKPD'" :menu="\App\Support\MenuDashboard::guru()">
    <a href="{{ route('guru.lkpd.index') }}" class="text-sm text-teal-700 dark:text-teal-400 hover:underline">&larr; Kembali</a>
    <h1 class="mt-2 text-2xl font-bold text-slate-900 dark:text-slate-100">{{ $sedangUbah ? 'Ubah LKPD' : 'Buat LKPD Baru' }}</h1>

    <form method="POST" action="{{ $sedangUbah ? route('guru.lkpd.update', $lkpd) : route('guru.lkpd.store') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @if($sedangUbah) @method('PUT') @endif

        <x-kartu class="space-y-4">
            <x-input label="Judul LKPD" name="judul" :value="$lkpd->judul" wajib />
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <x-select label="Mata Pelajaran" name="id_mata_pelajaran" wajib :opsi="$mataPelajaran->pluck('nama_mata_pelajaran', 'id')" selected="{{ $lkpd->id_mata_pelajaran }}" />
                <x-select label="Jenjang Pendidikan" name="id_jenjang_pendidikan" wajib :opsi="$jenjang->pluck('nama_jenjang', 'id')" selected="{{ $lkpd->id_jenjang_pendidikan }}" />
                <x-select label="E-Modul Terkait (opsional)" name="id_e_modul" :opsi="$eModulSaya->pluck('judul', 'id')" selected="{{ $lkpd->id_e_modul }}" />
                <x-select label="Jenis LKPD" name="jenis" wajib :opsi="['file' => 'Berkas PDF', 'digital' => 'LKPD Digital']" selected="{{ $lkpd->jenis ?? 'digital' }}" />
            </div>
            <x-textarea label="Deskripsi" name="deskripsi">{{ $lkpd->deskripsi }}</x-textarea>
            <x-textarea label="Petunjuk Pengerjaan" name="petunjuk">{{ $lkpd->petunjuk }}</x-textarea>
            <x-textarea label="Tujuan" name="tujuan">{{ $lkpd->tujuan }}</x-textarea>
            <x-textarea label="Aktivitas" name="aktivitas">{{ $lkpd->aktivitas }}</x-textarea>
            <x-textarea label="Pertanyaan" name="pertanyaan">{{ $lkpd->pertanyaan }}</x-textarea>
            <x-textarea label="Kesimpulan" name="kesimpulan">{{ $lkpd->kesimpulan }}</x-textarea>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <x-input type="file" label="Berkas PDF (opsional)" name="berkas_pdf" />
                <x-input type="file" label="Gambar Sampul" name="gambar_sampul" />
            </div>

            <label class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-400">
                <input type="hidden" name="izin_unduh" value="0">
                <input type="checkbox" name="izin_unduh" value="1" @checked($lkpd->izin_unduh ?? true) class="rounded border-slate-300 dark:border-slate-700 text-teal-700 dark:text-teal-400">
                Izinkan pengunjung mengunduh berkas
            </label>
        </x-kartu>

        <x-tombol type="submit">Simpan &amp; Publikasikan</x-tombol>
    </form>
</x-layout-dashboard>
