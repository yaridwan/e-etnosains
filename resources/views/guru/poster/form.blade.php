@php($sedangUbah = $poster->exists)

<x-layout-dashboard :judul-seo="$sedangUbah ? 'Ubah Poster' : 'Tambah Poster'" :menu="\App\Support\MenuDashboard::guru()">
    <a href="{{ route('guru.poster.index') }}" class="text-sm text-teal-700 dark:text-teal-400 hover:underline">&larr; Kembali</a>
    <h1 class="mt-2 text-2xl font-bold text-slate-900 dark:text-slate-100">{{ $sedangUbah ? 'Ubah Poster' : 'Tambah Poster' }}</h1>

    <form method="POST" action="{{ $sedangUbah ? route('guru.poster.update', $poster) : route('guru.poster.store') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @if($sedangUbah) @method('PUT') @endif

        <x-kartu class="space-y-4">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <x-input label="Judul" name="judul" :value="$poster->judul" wajib />
                <x-select label="E-Modul Terkait" name="id_e_modul" :opsi="$eModulSaya->pluck('judul', 'id')" selected="{{ $poster->id_e_modul }}" />
            </div>
            <x-textarea label="Deskripsi" name="deskripsi">{{ $poster->deskripsi }}</x-textarea>
            <x-unggah label="Gambar Poster" name="gambar" jenis="gambar" accept="image/*" :wajib="! $sedangUbah" :pratinjau="$poster->gambar ? \Illuminate\Support\Facades\Storage::url($poster->gambar) : null" />
        </x-kartu>

        <x-tombol type="submit">Simpan &amp; Publikasikan</x-tombol>
    </form>
</x-layout-dashboard>
