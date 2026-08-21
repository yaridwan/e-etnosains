<x-layout-dashboard judul-seo="E-Modul Saya" :menu="\App\Support\MenuDashboard::guru()">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">E-Modul Saya</h1>
        <x-tombol :href="route('guru.e-modul.create')">Buat E-Modul</x-tombol>
    </div>

    <x-kartu class="mt-6">
        @if($eModul->isEmpty())
            <x-empty-state judul="Belum ada E-Modul." deskripsi="Mulai bagikan pembelajaran berbasis etnosains Anda." teks-tombol="Buat E-Modul Pertama" :tautan-tombol="route('guru.e-modul.create')" />
        @else
            <table class="w-full text-left text-sm">
                <thead class="text-xs uppercase text-slate-400 dark:text-slate-500">
                    <tr><th class="pb-2">Judul</th><th class="pb-2">Mata Pelajaran</th><th class="pb-2">Status</th><th class="pb-2">Dilihat</th><th class="pb-2 text-right">Aksi</th></tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @foreach($eModul as $item)
                        <tr>
                            <td class="py-3 font-medium text-slate-700 dark:text-slate-300">{{ $item->judul }}</td>
                            <td class="py-3 text-slate-500 dark:text-slate-400">{{ $item->mataPelajaran->nama_mata_pelajaran }}</td>
                            <td class="py-3"><x-status-publikasi :status="$item->status_publikasi" /></td>
                            <td class="py-3 text-slate-500 dark:text-slate-400">{{ $item->jumlah_dilihat }}</td>
                            <td class="py-3 text-right space-x-3">
                                <a href="{{ route('guru.e-modul.preview', $item) }}" class="text-sm font-medium text-slate-600 dark:text-slate-400 hover:underline">Pratinjau</a>
                                <a href="{{ route('guru.e-modul.edit', $item) }}" class="text-sm font-medium text-teal-700 dark:text-teal-400 hover:underline">Ubah</a>
                                <x-form-hapus :aksi="route('guru.e-modul.destroy', $item)" class="inline" />
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">{{ $eModul->links() }}</div>
        @endif
    </x-kartu>
</x-layout-dashboard>
