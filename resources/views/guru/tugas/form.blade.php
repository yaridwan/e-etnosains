<x-layout-dashboard judul-seo="Buat Tugas" :menu="\App\Support\MenuDashboard::guru()">
    <a href="{{ route('guru.tugas.index') }}" class="text-sm text-teal-700 dark:text-teal-400 hover:underline">&larr; Kembali</a>
    <h1 class="mt-2 text-2xl font-bold text-slate-900 dark:text-slate-100">Buat Tugas Baru</h1>

    <form method="POST" action="{{ route('guru.tugas.store') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        <x-kartu class="space-y-4">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <x-select label="Kelas" name="id_kelas_belajar" wajib :opsi="$kelasSaya->pluck('nama_kelas', 'id')" selected="{{ $kelasTerpilih }}" />
                <x-input label="Judul Tugas" name="judul" wajib />
            </div>
            <x-textarea label="Petunjuk" name="petunjuk" />
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <x-input label="Tanggal Mulai" name="tanggal_mulai" type="datetime-local" />
                <x-input label="Batas Waktu" name="batas_waktu" type="datetime-local" />
                <x-input label="Bobot" name="bobot" type="number" value="100" />
            </div>
            <x-unggah label="Berkas Pendukung" name="berkas" jenis="dokumen" />
        </x-kartu>

        <x-tombol type="submit">Buat Tugas</x-tombol>
    </form>
</x-layout-dashboard>
