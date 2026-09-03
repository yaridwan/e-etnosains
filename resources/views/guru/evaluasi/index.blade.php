<x-layout-dashboard judul-seo="Evaluasi Saya" :menu="\App\Support\MenuDashboard::guru()">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Evaluasi Saya</h1>
        <x-tombol :href="route('guru.evaluasi.create')">Buat Evaluasi</x-tombol>
    </div>

    <x-kartu class="mt-6">
        @if($evaluasi->isEmpty())
            <x-empty-state judul="Belum ada evaluasi." deskripsi="Unggah berkas soal formatif, sumatif, atau ulangan untuk siswa Anda." teks-tombol="Buat Evaluasi Pertama" :tautan-tombol="route('guru.evaluasi.create')" />
        @else
            <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="text-xs uppercase text-slate-400 dark:text-slate-500">
                    <tr><th class="pb-2">Judul</th><th class="pb-2">Mata Pelajaran</th><th class="pb-2">Jenis</th><th class="pb-2">Dilihat</th><th class="pb-2 text-right">Aksi</th></tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @foreach($evaluasi as $item)
                        <tr>
                            <td class="py-3 font-medium text-slate-700 dark:text-slate-300">{{ $item->judul }}</td>
                            <td class="py-3 text-slate-500 dark:text-slate-400">{{ $item->mataPelajaran->nama_mata_pelajaran }}</td>
                            <td class="py-3"><x-badge warna="violet">{{ $item->labelJenisEvaluasi() }}</x-badge></td>
                            <td class="py-3 text-slate-500 dark:text-slate-400">{{ $item->jumlah_dilihat }}</td>
                            <td class="py-3 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <x-tombol-ikon :href="route('guru.evaluasi.edit', $item)" ikon="pensil" label="Ubah" />
                                    <x-form-hapus :aksi="route('guru.evaluasi.destroy', $item)" />
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
            <div class="mt-4">{{ $evaluasi->links() }}</div>
        @endif
    </x-kartu>
</x-layout-dashboard>
