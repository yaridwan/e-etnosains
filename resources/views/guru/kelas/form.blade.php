<x-layout-dashboard judul-seo="Buat Kelas Belajar" :menu="\App\Support\MenuDashboard::guru()">
    <a href="{{ route('guru.kelas.index') }}" class="text-sm text-teal-700 dark:text-teal-400 hover:underline">&larr; Kembali</a>
    <h1 class="mt-2 text-2xl font-bold text-slate-900 dark:text-slate-100">Buat Kelas Belajar</h1>

    <form method="POST" action="{{ route('guru.kelas.store') }}" class="mt-6 space-y-6">
        @csrf
        <x-kartu class="space-y-4">
            <x-input label="Nama Kelas" name="nama_kelas" wajib placeholder="Contoh: BIOLOGI X-A" />
            <x-select label="Mata Pelajaran" name="id_mata_pelajaran" wajib :opsi="$mataPelajaran->pluck('nama_mata_pelajaran', 'id')" />
            <x-input label="Tahun Ajaran" name="tahun_ajaran" placeholder="Contoh: 2026/2027" />
            <x-textarea label="Deskripsi" name="deskripsi" />
        </x-kartu>

        <x-tombol type="submit">Buat Kelas</x-tombol>
    </form>
</x-layout-dashboard>
