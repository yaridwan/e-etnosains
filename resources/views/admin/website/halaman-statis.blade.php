<x-layout-dashboard judul-seo="Halaman Statis" :menu="\App\Support\MenuDashboard::administrator()">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Halaman Statis</h1>
        <x-tombol x-data @click="$dispatch('buka-modal', 'tambah')">Tambah Halaman</x-tombol>
    </div>

    <form method="GET" class="mt-4 flex flex-wrap items-end gap-3">
        <div class="w-full sm:w-64">
            <x-input type="search" name="q" value="{{ request('q') }}" placeholder="Cari judul/konten..." />
        </div>
        <div class="w-full sm:w-44">
            <x-select name="status" placeholder="Semua Status" :opsi="['aktif' => 'Aktif', 'nonaktif' => 'Nonaktif']" :selected="request('status')" />
        </div>
        <x-tombol type="submit" varian="sekunder">Filter</x-tombol>
    </form>

    <x-kartu class="mt-6">
        <table class="w-full text-left text-sm">
            <thead class="text-xs uppercase text-slate-400 dark:text-slate-500">
                <tr><th class="pb-2">Judul</th><th class="pb-2">Alamat</th><th class="pb-2">Status</th><th class="pb-2 text-right">Aksi</th></tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($data as $item)
                    <tr>
                        <td class="py-3 font-medium text-slate-700 dark:text-slate-300">{{ $item->judul }}</td>
                        <td class="py-3 text-slate-500 dark:text-slate-400">/halaman/{{ $item->alamat_tautan }}</td>
                        <td class="py-3"><x-badge :warna="$item->aktif ? 'emerald' : 'slate'">{{ $item->aktif ? 'Aktif' : 'Nonaktif' }}</x-badge></td>
                        <td class="py-3 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <x-tombol-ikon type="button" x-data @click="$dispatch('buka-modal', 'edit-{{ $item->id }}')" ikon="pensil" label="Ubah" />
                                <x-form-hapus :aksi="route('admin.halaman-statis.destroy', $item)" />
                            </div>
                        </td>
                    </tr>

                    <x-modal :nama="'edit-'.$item->id" judul="Ubah Halaman Statis" lebar="max-w-2xl">
                        <form method="POST" action="{{ route('admin.halaman-statis.update', $item) }}" class="space-y-4">
                            @csrf @method('PUT')
                            <x-input label="Judul" name="judul" :value="$item->judul" wajib />
                            <x-textarea label="Konten (HTML)" name="konten" :baris="8" wajib petunjuk="Konten ditulis sebagai HTML mentah.">{{ $item->konten }}</x-textarea>
                            <x-checkbox name="aktif" :checked="$item->aktif">Aktifkan</x-checkbox>
                            <x-tombol type="submit" class="w-full">Simpan Perubahan</x-tombol>
                        </form>
                    </x-modal>
                @empty
                    <tr><td colspan="4"><x-empty-state judul="Belum ada halaman statis." deskripsi="{{ request('q') || request('status') ? 'Tidak ada halaman yang cocok dengan filter.' : null }}" /></td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">{{ $data->links() }}</div>
    </x-kartu>

    <x-modal nama="tambah" judul="Tambah Halaman Statis" lebar="max-w-2xl">
        <form method="POST" action="{{ route('admin.halaman-statis.store') }}" class="space-y-4">
            @csrf
            <x-input label="Judul" name="judul" wajib />
            <x-textarea label="Konten (HTML)" name="konten" :baris="8" wajib petunjuk="Konten ditulis sebagai HTML mentah." />
            <x-tombol type="submit" class="w-full">Simpan</x-tombol>
        </form>
    </x-modal>
</x-layout-dashboard>
