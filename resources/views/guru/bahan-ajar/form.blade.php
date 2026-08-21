@php($sedangUbah = $bahanAjar->exists)

<x-layout-dashboard :judul-seo="$sedangUbah ? 'Ubah Bahan Ajar' : 'Tambah Bahan Ajar'" :menu="\App\Support\MenuDashboard::guru()">
    <a href="{{ route('guru.bahan-ajar.index') }}" class="text-sm text-teal-700 dark:text-teal-400 hover:underline">&larr; Kembali</a>
    <h1 class="mt-2 text-2xl font-bold text-slate-900 dark:text-slate-100">{{ $sedangUbah ? 'Ubah Bahan Ajar' : 'Tambah Bahan Ajar' }}</h1>

    <form method="POST" action="{{ $sedangUbah ? route('guru.bahan-ajar.update', $bahanAjar) : route('guru.bahan-ajar.store') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @if($sedangUbah) @method('PUT') @endif

        <x-kartu class="space-y-4">
            <x-input label="Judul" name="judul" :value="$bahanAjar->judul" wajib />
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <x-select label="Mata Pelajaran" name="id_mata_pelajaran" wajib :opsi="$mataPelajaran->pluck('nama_mata_pelajaran', 'id')" selected="{{ $bahanAjar->id_mata_pelajaran }}" />
                <x-select label="Jenjang Pendidikan" name="id_jenjang_pendidikan" wajib :opsi="$jenjang->pluck('nama_jenjang', 'id')" selected="{{ $bahanAjar->id_jenjang_pendidikan }}" />
                <x-select label="Topik Etnosains" name="id_topik_etnosains" :opsi="$topik->pluck('nama_topik', 'id')" selected="{{ $bahanAjar->id_topik_etnosains }}" />
                <x-select label="Jenis Berkas" name="jenis_berkas" wajib :opsi="['pdf'=>'PDF','ppt'=>'PPT/PPTX','doc'=>'DOC/DOCX','gambar'=>'Gambar','tautan'=>'Tautan Eksternal']" selected="{{ $bahanAjar->jenis_berkas }}" />
            </div>
            <x-textarea label="Deskripsi" name="deskripsi">{{ $bahanAjar->deskripsi }}</x-textarea>
            <x-input label="Tautan Eksternal (jika ada)" name="tautan_eksternal" :value="$bahanAjar->tautan_eksternal" />
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <x-input type="file" label="Berkas" name="berkas" />
                <x-input type="file" label="Gambar Sampul" name="gambar_sampul" />
            </div>
        </x-kartu>

        <x-tombol type="submit">Simpan &amp; Publikasikan</x-tombol>
    </form>
</x-layout-dashboard>
