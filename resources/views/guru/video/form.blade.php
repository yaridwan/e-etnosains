@php($sedangUbah = $video->exists)

<x-layout-dashboard :judul-seo="$sedangUbah ? 'Ubah Video' : 'Tambah Video'" :menu="\App\Support\MenuDashboard::guru()">
    <a href="{{ route('guru.video.index') }}" class="text-sm text-teal-700 dark:text-teal-400 hover:underline">&larr; Kembali</a>
    <h1 class="mt-2 text-2xl font-bold text-slate-900 dark:text-slate-100">{{ $sedangUbah ? 'Ubah Video Pembelajaran' : 'Tambah Video Pembelajaran' }}</h1>

    <form method="POST" action="{{ $sedangUbah ? route('guru.video.update', $video) : route('guru.video.store') }}" class="mt-6 space-y-6">
        @csrf
        @if($sedangUbah) @method('PUT') @endif

        <x-kartu class="space-y-4">
            <x-input label="Judul" name="judul" :value="$video->judul" wajib />
            <x-input label="URL YouTube" name="url_video" :value="$video->url_video" wajib placeholder="https://www.youtube.com/watch?v=..." />
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <x-select label="Mata Pelajaran" name="id_mata_pelajaran" wajib :opsi="$mataPelajaran->pluck('nama_mata_pelajaran', 'id')" selected="{{ $video->id_mata_pelajaran }}" />
                <x-select label="Topik Etnosains" name="id_topik_etnosains" :opsi="$topik->pluck('nama_topik', 'id')" selected="{{ $video->id_topik_etnosains }}" />
                <x-select label="E-Modul Terkait" name="id_e_modul" :opsi="$eModulSaya->pluck('judul', 'id')" selected="{{ $video->id_e_modul }}" />
            </div>
            <x-textarea label="Deskripsi" name="deskripsi">{{ $video->deskripsi }}</x-textarea>
        </x-kartu>

        <x-tombol type="submit">Simpan &amp; Publikasikan</x-tombol>
    </form>
</x-layout-dashboard>
