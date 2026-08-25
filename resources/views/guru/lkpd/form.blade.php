@php($sedangUbah = $lkpd->exists)

<x-layout-dashboard :judul-seo="$sedangUbah ? 'Ubah LKPD' : 'Buat LKPD'" :menu="\App\Support\MenuDashboard::guru()">
    <a href="{{ route('guru.lkpd.index') }}" class="text-sm text-teal-700 dark:text-teal-400 hover:underline">&larr; Kembali</a>
    <h1 class="mt-2 text-2xl font-bold text-slate-900 dark:text-slate-100">{{ $sedangUbah ? 'Ubah LKPD' : 'Buat LKPD Baru' }}</h1>

    <form method="POST" action="{{ $sedangUbah ? route('guru.lkpd.update', $lkpd) : route('guru.lkpd.store') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @if($sedangUbah) @method('PUT') @endif

        <x-kartu>
            <x-judul-form-seksi :nomor="1">Informasi Dasar</x-judul-form-seksi>
            <div class="space-y-4">
                <x-input label="Judul LKPD" name="judul" :value="$lkpd->judul" wajib />
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <x-select label="Mata Pelajaran" name="id_mata_pelajaran" wajib :opsi="$mataPelajaran->pluck('nama_mata_pelajaran', 'id')" selected="{{ $lkpd->id_mata_pelajaran }}" />
                    <x-select label="Jenjang Pendidikan" name="id_jenjang_pendidikan" wajib :opsi="$jenjang->pluck('nama_jenjang', 'id')" selected="{{ $lkpd->id_jenjang_pendidikan }}" />
                    <x-select label="E-Modul Terkait (opsional)" name="id_e_modul" :opsi="$eModulSaya->pluck('judul', 'id')" selected="{{ $lkpd->id_e_modul }}" />
                    <x-select label="Jenis LKPD" name="jenis" wajib :opsi="['file' => 'Berkas PDF', 'digital' => 'LKPD Digital']" selected="{{ $lkpd->jenis ?? 'digital' }}" />
                </div>
            </div>
        </x-kartu>

        <x-kartu>
            <x-judul-form-seksi :nomor="2">Konten LKPD</x-judul-form-seksi>
            <div class="space-y-4">
                <x-textarea label="Deskripsi" name="deskripsi">{{ $lkpd->deskripsi }}</x-textarea>
                <x-textarea label="Petunjuk Pengerjaan" name="petunjuk">{{ $lkpd->petunjuk }}</x-textarea>
                <x-textarea label="Tujuan" name="tujuan">{{ $lkpd->tujuan }}</x-textarea>
                <x-textarea label="Aktivitas" name="aktivitas">{{ $lkpd->aktivitas }}</x-textarea>
                <x-textarea label="Pertanyaan" name="pertanyaan">{{ $lkpd->pertanyaan }}</x-textarea>
                <x-textarea label="Kesimpulan" name="kesimpulan">{{ $lkpd->kesimpulan }}</x-textarea>
            </div>
        </x-kartu>

        <x-kartu>
            <x-judul-form-seksi :nomor="3">Berkas &amp; Publikasi</x-judul-form-seksi>
            <div class="space-y-4">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <x-unggah label="Berkas PDF (opsional)" name="berkas_pdf" jenis="dokumen" accept="application/pdf" :pratinjau="$lkpd->berkas_pdf ? \Illuminate\Support\Facades\Storage::url($lkpd->berkas_pdf) : null" />
                    <x-unggah label="Gambar Sampul" name="gambar_sampul" jenis="gambar" accept="image/*" :pratinjau="$lkpd->gambar_sampul ? \Illuminate\Support\Facades\Storage::url($lkpd->gambar_sampul) : null" />
                </div>

                <x-checkbox name="izin_unduh" :checked="$lkpd->izin_unduh ?? true">
                    Izinkan pengunjung mengunduh berkas
                </x-checkbox>
            </div>
        </x-kartu>

        <x-tombol type="submit">Simpan &amp; Publikasikan</x-tombol>
    </form>

    @if($sedangUbah)
        <x-kartu class="mt-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="font-semibold text-slate-800 dark:text-slate-100">LKPD Interaktif</h2>
                    <p class="text-sm text-slate-400 dark:text-slate-500">Versi yang bisa diisi dan dikumpulkan siswa langsung secara daring, memakai instrumen dinamis (11 jenis pertanyaan).</p>
                </div>
                <x-tombol :href="route('guru.observasi.create', ['lkpd' => $lkpd->id])" varian="sekunder">+ Buat Versi Interaktif</x-tombol>
            </div>

            <ul class="mt-4 space-y-2">
                @forelse($lkpd->observasi as $observasiTerkait)
                    <li class="flex items-center justify-between gap-3 rounded-lg border border-slate-100 dark:border-slate-800 px-4 py-2.5 text-sm">
                        <span class="font-medium text-slate-700 dark:text-slate-300">{{ $observasiTerkait->judul }}</span>
                        <a href="{{ route('guru.observasi.edit', $observasiTerkait) }}" class="text-teal-700 dark:text-teal-400 hover:underline">Kelola Butir Soal</a>
                    </li>
                @empty
                    <li class="text-sm text-slate-400 dark:text-slate-500">Belum ada versi interaktif untuk LKPD ini. Siswa hanya akan melihat berkas PDF.</li>
                @endforelse
            </ul>
        </x-kartu>
    @endif
</x-layout-dashboard>
